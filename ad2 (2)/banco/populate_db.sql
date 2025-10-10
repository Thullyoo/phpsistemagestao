USE sistema_eventos;

INSERT INTO participantes (nome, email, matricula, curso) VALUES
('Ana Souza', 'ana.souza@example.com', '2025001', 'Ciência da Computação'),
('Bruno Lima', 'bruno.lima@example.com', '2025002', 'Engenharia de Software'),
('Carla Mendes', 'carla.mendes@example.com', '2025003', 'Sistemas de Informação'),
('Diego Ferreira', 'diego.ferreira@example.com', '2025004', 'Engenharia Elétrica');

INSERT INTO eventos (nome, descricao, data_evento, vagas, carga_horaria) VALUES
('Semana Acadêmica de Tecnologia', 'Evento com palestras e workshops sobre tecnologia.', '2025-11-10 09:00:00', 100, 20),
('Workshop de Inteligência Artificial', 'Oficina prática sobre modelos de IA e aplicações.', '2025-11-15 14:00:00', 50, 8),
('Congresso de Inovação', 'Encontro de pesquisadores e profissionais da área de inovação.', '2025-12-01 08:00:00', 200, 40);

INSERT INTO inscricoes (participante_id, evento_id, status) VALUES
(1, 1, 'ativa'),
(2, 1, 'ativa'),
(3, 2, 'ativa'),
(1, 2, 'ativa'),
(4, 3, 'ativa'),
(2, 2, 'cancelada'); 
