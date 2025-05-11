--
-- Banco de dados: `juventude`
--
CREATE DATABASE IF NOT EXISTS `juventude` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `juventude`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `apadrinhado`
--

CREATE TABLE `apadrinhado` (
  `id_apadrinhado` int(11) NOT NULL,
  `nome_apadrinhado` varchar(255) NOT NULL,
  `telefone_apadrinhado` varchar(11) NOT NULL,
  `nascimento_apadrinhado` date NOT NULL,
  `descricao_apadrinhado` text NOT NULL,
  `id_padrinho` int(11) NOT NULL,
  `id_temperamento` int(11) NOT NULL,
  `id_comportamento` int(11) NOT NULL,
  `id_ling_amor` int(11) NOT NULL,
  `status_voluntario` enum('nenhum','junior','oficial') NOT NULL,
  `batizado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comportamento`
--

CREATE TABLE `comportamento` (
  `id_comportamento` int(11) NOT NULL,
  `nome_comportamento` varchar(255) NOT NULL,
  `descricao_comportamento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comportamento`
--

INSERT INTO `comportamento` (`id_comportamento`, `nome_comportamento`, `descricao_comportamento`) VALUES
(1, 'Comunicador', 'O Comunicador é extrovertido, otimista e empático. Ele valoriza relacionamentos interpessoais, gosta de inspirar e motivar as pessoas ao seu redor e se sente confortável em ambientes colaborativos. Porém, pode ser desorganizado e ter dificuldade em lidar com tarefas técnicas ou rotineiras.'),
(2, 'Executor', 'O Executor é determinado, direto e orientado para resultados. Gosta de desafios, toma decisões rápidas e tem perfil de liderança natural. Seu foco está na resolução de problemas e na conquista de metas. Contudo, pode ser visto como autoritário ou impaciente, e às vezes desconsidera detalhes importantes.'),
(3, 'Planejador', 'O Planejador é estável, confiável e organizado. Ele prefere ambientes estruturados, valoriza harmonia e trabalha bem sob prazos. É calmo em situações adversas e comprometido com a qualidade. No entanto, pode resistir a mudanças e apresentar dificuldade em situações de alta pressão ou imprevisibilidade.'),
(4, 'Analista', 'O Analista é racional, perfeccionista e altamente detalhista. Ele se orienta por dados e evidências, busca precisão e prefere decisões baseadas em lógica. Ideal para resolver problemas complexos, pode, porém, ser excessivamente crítico e encontrar dificuldades em lidar com imprevistos ou pressão.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `discipulado`
--

CREATE TABLE `discipulado` (
  `id_discipulado` int(11) NOT NULL,
  `id_padrinho` int(11) NOT NULL,
  `id_apadrinhado` int(11) NOT NULL,
  `data_discipulado` date NOT NULL,
  `local_discipulado` varchar(255) NOT NULL,
  `descricao_discipulado` text NOT NULL,
  `nivel_acesso` enum('publico','privado') NOT NULL,
  `data_alteracao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `feedback`
--

CREATE TABLE `feedback` (
  `id_feedback` int(11) NOT NULL,
  `id_discipulado` int(11) NOT NULL,
  `id_padrinho` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `avaliacao` enum('ruim','medio','bom') NOT NULL,
  `data_alteracao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `linguagem_amor`
--

CREATE TABLE `linguagem_amor` (
  `id_linguagem` int(11) NOT NULL,
  `nome_linguagem` varchar(255) NOT NULL,
  `descricao_linguagem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `linguagem_amor`
--

INSERT INTO `linguagem_amor` (`id_linguagem`, `nome_linguagem`, `descricao_linguagem`) VALUES
(1, 'Palavras de Afirmação', 'As pessoas que têm essa linguagem valorizam elogios, palavras encorajadoras e declarações de amor. Elas se sentem mais amadas quando ouvem verbalmente o quanto são importantes. Porém, críticas podem ter um impacto emocional profundo sobre elas.'),
(2, 'Tempo de Qualidade', 'Essa linguagem foca na atenção plena e na conexão genuína. Estar presente, sem distrações, é essencial para essas pessoas. Elas valorizam conversas significativas e atividades compartilhadas. Ausência ou falta de atenção podem ser especialmente dolorosas.'),
(3, 'Presentes', 'Presentes têm um valor simbólico para quem tem essa linguagem. Não é sobre o custo, mas sobre o significado do gesto. Eles veem os presentes como uma demonstração concreta de carinho. Esquecimentos ou presentes sem consideração podem ser frustrantes.'),
(4, 'Atos de Serviço', 'Para essas pessoas, ações falam mais alto que palavras. Elas se sentem amadas quando os outros fazem algo por elas, como ajudar em tarefas ou resolver problemas. Descuidos ou falta de iniciativa podem ser interpretados como desinteresse.'),
(5, 'Toque Físico', 'O toque é a principal forma de demonstrar amor para quem tem essa linguagem. Abraços, beijos e carinhos proporcionam conforto e segurança emocional. A ausência de contato físico pode fazê-las sentir-se desconectadas ou rejeitadas.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `id_emissor` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `id_apadrinhado` int(11) NOT NULL,
  `mensagem` varchar(255) NOT NULL,
  `data_mensagem` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ministerio`
--

CREATE TABLE `ministerio` (
  `id_ministerio` int(11) NOT NULL,
  `nome_ministerio` varchar(255) NOT NULL,
  `descricao_ministerio` varchar(255) NOT NULL,
  `nome_lider` varchar(50) NOT NULL,
  `telefone_lider` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ministerio`
--

INSERT INTO `ministerio` (`id_ministerio`, `nome_ministerio`, `descricao_ministerio`, `nome_lider`, `telefone_lider`) VALUES
(1, 'Louvor', 'Ministério de Louvor e Artes', 'Pastora Roberta', '11968336556'),
(2, 'Som', 'Ministério de Sonoplastia', 'Pastora Roberta', '11968336556'),
(3, 'Gidul (Crianças)', 'Ministério de Crianças', 'Beatriz Camilo', '11966200417'),
(4, 'Ravah (Juniores)', 'Ministério de Juniores', 'Pastora Filomena', '11998627360'),
(5, 'Koinonia', 'Cozinha, Bomboniere e Caixa', 'Pastora Filomena', '11998627360'),
(6, 'Transmissão', 'Ministério de Transmissão', 'Afonso', '11980217377'),
(7, 'Multimídia', 'Ministério da Multimídia', 'Kamilly', '11960835439'),
(8, 'Mídias Sociais e Fotos', 'Ministério de Mídias e Fotografia', 'Afonso Galdino', '11980217377'),
(9, 'Diaconato', 'Ministério do Diaconato', 'Pastora Maura', '11952324401');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ministerio_apadr`
--

CREATE TABLE `ministerio_apadr` (
  `id_ministerio` int(11) NOT NULL,
  `id_apadrinhado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

--
-- Estrutura para tabela `padrinho`
--

CREATE TABLE `padrinho` (
  `id_padrinho` int(11) NOT NULL,
  `nome_padrinho` varchar(255) NOT NULL,
  `telefone_padrinho` varchar(11) NOT NULL,
  `descricao_padrinho` text NOT NULL,
  `id_comportamento` int(11) NOT NULL,
  `id_temperamento` int(11) NOT NULL,
  `id_ling_amor` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `status` enum('comum','administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `padrinho`
--

INSERT INTO `padrinho` (`id_padrinho`, `nome_padrinho`, `telefone_padrinho`, `descricao_padrinho`, `id_comportamento`, `id_temperamento`, `id_ling_amor`, `usuario`, `senha`, `status`) VALUES
(1, 'Administrador', '11999999999', 'Perfil de Administrador', 3, 2, 2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'administrador'),
(2, 'Usuário Comum', '11988888888', 'Perfil de Administrador', 3, 2, 2, 'comum', '6d769ecb25444b49111b669de9ec6104', 'comum');

-- --------------------------------------------------------

--
-- Estrutura para tabela `redes_apadr`
--

CREATE TABLE `redes_apadr` (
  `id_apadrinhado` int(11) NOT NULL,
  `id_rede_social` int(11) NOT NULL,
  `complemento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `redes_sociais`
--

CREATE TABLE `redes_sociais` (
  `id_rede_social` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `redes_sociais`
--

INSERT INTO `redes_sociais` (`id_rede_social`, `nome`) VALUES
(1, 'Instagram'),
(2, 'Facebook'),
(3, 'Twitter'),
(4, 'TikTok');

-- --------------------------------------------------------

--
-- Estrutura para tabela `temperamento`
--

CREATE TABLE `temperamento` (
  `id_temperamento` int(11) NOT NULL,
  `nome_temperamento` varchar(255) NOT NULL,
  `descricao_temperamento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `temperamento`
--

INSERT INTO `temperamento` (`id_temperamento`, `nome_temperamento`, `descricao_temperamento`) VALUES
(1, 'Sanguíneo', 'O Sanguíneo é extrovertido, alegre e comunicativo. Ele gosta de socializar, contagiar as pessoas com seu entusiasmo e vive intensamente o presente. É criativo e espontâneo, mas pode ser impulsivo, distraído e ter dificuldade em manter compromissos ou concluir tarefas.'),
(2, 'Colérico', 'O Colérico é enérgico, determinado e orientado para a ação. Ele possui uma forte liderança natural e busca constantemente atingir seus objetivos. Com uma personalidade assertiva, pode ser impaciente e ter pouca tolerância com erros ou opiniões divergentes.'),
(3, 'Fleumático', 'O Fleumático é calmo, equilibrado e introspectivo. Ele valoriza a estabilidade, evita conflitos e é um excelente mediador. É confiável e paciente, mas pode ser visto como passivo ou acomodado, preferindo muitas vezes seguir o fluxo em vez de enfrentar mudanças.'),
(4, 'Melancólico', 'O Melancólico é perfeccionista, sensível e analítico. Ele é focado nos detalhes, pensa profundamente e possui um grande senso estético e ético. No entanto, tende a ser pessimista, crítico consigo mesmo e com os outros, além de evitar riscos por medo de errar.');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `apadrinhado`
--
ALTER TABLE `apadrinhado`
  ADD PRIMARY KEY (`id_apadrinhado`),
  ADD KEY `id_comportamento` (`id_comportamento`),
  ADD KEY `id_ling_amor` (`id_ling_amor`),
  ADD KEY `id_temperamento` (`id_temperamento`),
  ADD KEY `id_padrinho` (`id_padrinho`);

--
-- Índices de tabela `comportamento`
--
ALTER TABLE `comportamento`
  ADD PRIMARY KEY (`id_comportamento`);

--
-- Índices de tabela `discipulado`
--
ALTER TABLE `discipulado`
  ADD PRIMARY KEY (`id_discipulado`),
  ADD KEY `id_apadrinhado` (`id_apadrinhado`),
  ADD KEY `id_padrinho` (`id_padrinho`);

--
-- Índices de tabela `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id_feedback`),
  ADD KEY `id_discipulado` (`id_discipulado`),
  ADD KEY `id_padrinho` (`id_padrinho`);

--
-- Índices de tabela `linguagem_amor`
--
ALTER TABLE `linguagem_amor`
  ADD PRIMARY KEY (`id_linguagem`);

--
-- Índices de tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD KEY `id_apadrinhado` (`id_apadrinhado`),
  ADD KEY `id_emissor` (`id_emissor`),
  ADD KEY `id_receptor` (`id_receptor`);

--
-- Índices de tabela `ministerio`
--
ALTER TABLE `ministerio`
  ADD PRIMARY KEY (`id_ministerio`);

--
-- Índices de tabela `ministerio_apadr`
--
ALTER TABLE `ministerio_apadr`
  ADD KEY `id_apadrinhado` (`id_apadrinhado`),
  ADD KEY `id_ministerio` (`id_ministerio`);

--
-- Índices de tabela `padrinho`
--
ALTER TABLE `padrinho`
  ADD PRIMARY KEY (`id_padrinho`),
  ADD KEY `id_comportamento` (`id_comportamento`),
  ADD KEY `id_ling_amor` (`id_ling_amor`),
  ADD KEY `id_temperamento` (`id_temperamento`);

--
-- Índices de tabela `redes_apadr`
--
ALTER TABLE `redes_apadr`
  ADD KEY `id_apadrinhado` (`id_apadrinhado`),
  ADD KEY `id_rede_social` (`id_rede_social`);

--
-- Índices de tabela `redes_sociais`
--
ALTER TABLE `redes_sociais`
  ADD PRIMARY KEY (`id_rede_social`);

--
-- Índices de tabela `temperamento`
--
ALTER TABLE `temperamento`
  ADD PRIMARY KEY (`id_temperamento`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `apadrinhado`
--
ALTER TABLE `apadrinhado`
  MODIFY `id_apadrinhado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de tabela `comportamento`
--
ALTER TABLE `comportamento`
  MODIFY `id_comportamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `discipulado`
--
ALTER TABLE `discipulado`
  MODIFY `id_discipulado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de tabela `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de tabela `linguagem_amor`
--
ALTER TABLE `linguagem_amor`
  MODIFY `id_linguagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `ministerio`
--
ALTER TABLE `ministerio`
  MODIFY `id_ministerio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `padrinho`
--
ALTER TABLE `padrinho`
  MODIFY `id_padrinho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `redes_sociais`
--
ALTER TABLE `redes_sociais`
  MODIFY `id_rede_social` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `temperamento`
--
ALTER TABLE `temperamento`
  MODIFY `id_temperamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `apadrinhado`
--
ALTER TABLE `apadrinhado`
  ADD CONSTRAINT `apadrinhado_ibfk_1` FOREIGN KEY (`id_comportamento`) REFERENCES `comportamento` (`id_comportamento`),
  ADD CONSTRAINT `apadrinhado_ibfk_2` FOREIGN KEY (`id_ling_amor`) REFERENCES `linguagem_amor` (`id_linguagem`),
  ADD CONSTRAINT `apadrinhado_ibfk_3` FOREIGN KEY (`id_temperamento`) REFERENCES `temperamento` (`id_temperamento`),
  ADD CONSTRAINT `apadrinhado_ibfk_4` FOREIGN KEY (`id_padrinho`) REFERENCES `padrinho` (`id_padrinho`);

--
-- Restrições para tabelas `discipulado`
--
ALTER TABLE `discipulado`
  ADD CONSTRAINT `discipulado_ibfk_1` FOREIGN KEY (`id_apadrinhado`) REFERENCES `apadrinhado` (`id_apadrinhado`),
  ADD CONSTRAINT `discipulado_ibfk_2` FOREIGN KEY (`id_padrinho`) REFERENCES `padrinho` (`id_padrinho`);

--
-- Restrições para tabelas `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_discipulado`) REFERENCES `discipulado` (`id_discipulado`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`id_padrinho`) REFERENCES `padrinho` (`id_padrinho`);

--
-- Restrições para tabelas `mensagem`
--
ALTER TABLE `mensagem`
  ADD CONSTRAINT `mensagem_ibfk_1` FOREIGN KEY (`id_apadrinhado`) REFERENCES `apadrinhado` (`id_apadrinhado`),
  ADD CONSTRAINT `mensagem_ibfk_2` FOREIGN KEY (`id_emissor`) REFERENCES `padrinho` (`id_padrinho`),
  ADD CONSTRAINT `mensagem_ibfk_3` FOREIGN KEY (`id_receptor`) REFERENCES `padrinho` (`id_padrinho`);

--
-- Restrições para tabelas `ministerio_apadr`
--
ALTER TABLE `ministerio_apadr`
  ADD CONSTRAINT `ministerio_apadr_ibfk_1` FOREIGN KEY (`id_apadrinhado`) REFERENCES `apadrinhado` (`id_apadrinhado`),
  ADD CONSTRAINT `ministerio_apadr_ibfk_2` FOREIGN KEY (`id_ministerio`) REFERENCES `ministerio` (`id_ministerio`);

--
-- Restrições para tabelas `padrinho`
--
ALTER TABLE `padrinho`
  ADD CONSTRAINT `padrinho_ibfk_1` FOREIGN KEY (`id_comportamento`) REFERENCES `comportamento` (`id_comportamento`),
  ADD CONSTRAINT `padrinho_ibfk_2` FOREIGN KEY (`id_ling_amor`) REFERENCES `linguagem_amor` (`id_linguagem`),
  ADD CONSTRAINT `padrinho_ibfk_3` FOREIGN KEY (`id_temperamento`) REFERENCES `temperamento` (`id_temperamento`);

--
-- Restrições para tabelas `redes_apadr`
--
ALTER TABLE `redes_apadr`
  ADD CONSTRAINT `redes_apadr_ibfk_1` FOREIGN KEY (`id_apadrinhado`) REFERENCES `apadrinhado` (`id_apadrinhado`),
  ADD CONSTRAINT `redes_apadr_ibfk_2` FOREIGN KEY (`id_rede_social`) REFERENCES `redes_sociais` (`id_rede_social`);
COMMIT;