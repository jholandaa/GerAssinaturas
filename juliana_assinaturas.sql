-- ===========================================
-- JULIANA HOLANDA - TRABALHO BANCO DE DADOS II
-- TEMA: GERENCIAMENTO DE ASSINATURAS
-- PROFESSOR: JOÃO PAULO
-- ===========================================

-- ========== CRIAÇÃO DAS TABELAS ==========

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    data_cadastro DATE DEFAULT CURRENT_DATE
);

-- Tabela de planos
CREATE TABLE IF NOT EXISTS planos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    preco NUMERIC(10,2) NOT NULL,
    duracao_meses INTEGER NOT NULL CHECK (duracao_meses > 0)
);

-- Tabela de assinaturas
CREATE TABLE IF NOT EXISTS assinaturas (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id),
    plano_id INTEGER NOT NULL REFERENCES planos(id),
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    status VARCHAR(20) NOT NULL CHECK (status IN ('ativa', 'cancelada', 'expirada'))
);

-- Tabela de pagamentos
CREATE TABLE IF NOT EXISTS pagamentos (
    id SERIAL PRIMARY KEY,
    assinatura_id INTEGER NOT NULL REFERENCES assinaturas(id),
    data_pagamento DATE NOT NULL,
    valor NUMERIC(10,2) NOT NULL
);

-- ========== INSERÇÃO DE DADOS INICIAIS ==========

-- Usuários de teste
INSERT INTO usuarios (nome, email) VALUES
('Juliana Holanda', 'juliana@email.com'),
('Carlos Silva', 'carlos@email.com');

-- Planos disponíveis
INSERT INTO planos (nome, preco, duracao_meses) VALUES
('Plano Básico', 19.90, 1),
('Plano Padrão', 29.90, 3),
('Plano Premium', 49.90, 6);

-- ========== PROCEDURE: REGISTRAR ASSINATURA ==========

CREATE OR REPLACE PROCEDURE registrar_assinatura(
    IN p_usuario_id INTEGER,
    IN p_plano_id INTEGER
)
LANGUAGE plpgsql
AS $$
DECLARE
    v_duracao INTEGER;
    v_data_inicio DATE := CURRENT_DATE;
    v_data_fim DATE;
BEGIN
    SELECT duracao_meses INTO v_duracao
    FROM planos
    WHERE id = p_plano_id;

    v_data_fim := v_data_inicio + (v_duracao * INTERVAL '1 month');

    INSERT INTO assinaturas (usuario_id, plano_id, data_inicio, data_fim, status)
    VALUES (p_usuario_id, p_plano_id, v_data_inicio, v_data_fim, 'ativa');
END;
$$;

-- ========== FUNCTION: VERIFICAR SE ASSINATURA ESTÁ ATIVA ==========

CREATE OR REPLACE FUNCTION assinatura_esta_ativa(p_assinatura_id INTEGER)
RETURNS BOOLEAN
LANGUAGE plpgsql
AS $$
DECLARE
    v_status VARCHAR(20);
    v_data_inicio DATE;
    v_data_fim DATE;
    
BEGIN
      SELECT status, data_inicio, data_fim
    INTO v_status, v_data_inicio, v_data_fim
    FROM assinaturas
    WHERE id = p_assinatura_id;

 RETURN (v_status = 'ativa' AND CURRENT_DATE BETWEEN v_data_inicio AND v_data_fim);
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        RETURN FALSE;
END;
$$;

-- ========== TRIGGER: ATUALIZAR STATUS PARA 'EXPIRADA' ==========

-- Função da trigger
CREATE OR REPLACE FUNCTION verificar_expiracao()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
BEGIN
    IF NEW.data_fim < CURRENT_DATE THEN
        NEW.status := 'expirada';
    END IF;
    RETURN NEW;
END;
$$;

-- Trigger associada à tabela
CREATE TRIGGER trigger_verificar_expiracao
BEFORE INSERT OR UPDATE ON assinaturas
FOR EACH ROW
EXECUTE FUNCTION verificar_expiracao();

-- ========== TESTES OPCIONAIS ==========
-- SELECT * FROM usuarios;
-- SELECT * FROM planos;

-- Registrar nova assinatura (Juliana no Plano Premium)
-- CALL registrar_assinatura(4, 3);

-- Verificar se a assinatura está ativa
-- SELECT assinatura_esta_ativa(3);
-- SELECT assinatura_esta_ativa(4);

-- Forçar expiração da assinatura ID 3
-- UPDATE assinaturas SET data_fim = CURRENT_DATE - 1 WHERE id = 3;
-- UPDATE assinaturas SET plano_id = plano_id WHERE id = 3;

-- Verificar resultado final
-- SELECT * FROM assinaturas;
