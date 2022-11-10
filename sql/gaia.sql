-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Jun-2022 às 15:34
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gaia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `advogado`
--

CREATE TABLE `advogado` (
  `id` int(5) NOT NULL,
  `nome` varchar(160) NOT NULL,
  `oab` varchar(80) NOT NULL,
  `funcionario` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `advogado`
--

INSERT INTO `advogado` (`id`, `nome`, `oab`, `funcionario`) VALUES
(2, 'matheus portes', '19348', 1),
(3, 'Matheus', '1345', 3),
(4, 'Matheus', '15674', 4),
(5, 'Matheus', '134412', 5),
(6, 'Matheus teste de cargo', '99994', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(5) NOT NULL,
  `cpf` varchar(80) NOT NULL,
  `nome` varchar(180) NOT NULL,
  `usuario` varchar(60) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `avatar` varchar(180) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `cpf`, `nome`, `usuario`, `senha`, `avatar`) VALUES
(1, '0000000', 'luana', 'luana', '123', ''),
(2, '555555', 'Matheus Portes', 'matheusinho', 'e7d80ffeefa212b7c5c55700e4f7193e', ''),
(3, '5555', 'Matheus 1000 grau', 'matheus', '202cb962ac59075b964b07152d234b70', ''),
(4, '5555', 'Matheus Portes', 'matheus.secret', 'e7d80ffeefa212b7c5c55700e4f7193e', ''),
(5, '5555', 'Matheus', 'matheusinho.cliente', 'e7d80ffeefa212b7c5c55700e4f7193e', ''),
(6, '5555', 'Matheus', 'matheus.secret', '202cb962ac59075b964b07152d234b70', ''),
(7, '5555', 'Matheus', 'matheus.secret', '202cb962ac59075b964b07152d234b70', ''),
(8, '5555', 'Matheus', 'matheus.secret', '202cb962ac59075b964b07152d234b70', '.jpg'),
(9, '5555', 'Matheus', 'matheus.secret', '202cb962ac59075b964b07152d234b70', 'matheus.secret.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(5) NOT NULL,
  `nome` varchar(160) NOT NULL,
  `cargo` varchar(60) NOT NULL,
  `oab` varchar(80) DEFAULT NULL,
  `usuario` varchar(60) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `avatar` varchar(180) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`id`, `nome`, `cargo`, `oab`, `usuario`, `senha`, `avatar`) VALUES
(1, 'matheus portes', 'advogado', '19348', 'matheus.portes', '202cb962ac59075b964b07152d234b70', ''),
(2, 'Matheus', 'secretario', NULL, 'matheus.secret', '202cb962ac59075b964b07152d234b70', ''),
(3, 'Matheus', 'advogado', NULL, 'matheus.adv', '202cb962ac59075b964b07152d234b70', ''),
(4, 'Matheus', 'advogado', NULL, 'matheus.adv2', '202cb962ac59075b964b07152d234b70', ''),
(5, 'Matheus', 'advogado', NULL, 'matheus.adv3', '202cb962ac59075b964b07152d234b70', ''),
(6, 'Matheus teste de cargo', 'advogado', '99994', 'matheus.advNovo', 'e7d80ffeefa212b7c5c55700e4f7193e', 'matheus.advNovo.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `processo`
--

CREATE TABLE `processo` (
  `id` int(5) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `assunto` varchar(180) NOT NULL,
  `movimentacao` date NOT NULL,
  `cliente` int(5) NOT NULL,
  `vara` int(5) NOT NULL,
  `advogado` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `processo`
--

INSERT INTO `processo` (`id`, `numero`, `assunto`, `movimentacao`, `cliente`, `vara`, `advogado`) VALUES
(2, '1213123', 'adssdads', '2022-06-11', 3, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reuniao`
--

CREATE TABLE `reuniao` (
  `id` int(5) NOT NULL,
  `data` date NOT NULL,
  `assunto` varchar(180) NOT NULL,
  `cliente` int(5) NOT NULL,
  `advogado` int(5) NOT NULL,
  `processo` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `reuniao`
--

INSERT INTO `reuniao` (`id`, `data`, `assunto`, `cliente`, `advogado`, `processo`) VALUES
(14, '2022-06-08', 'dasdas', 3, 2, NULL),
(16, '2022-06-29', '31232', 3, 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vara`
--

CREATE TABLE `vara` (
  `id` int(5) NOT NULL,
  `nome` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vara`
--

INSERT INTO `vara` (`id`, `nome`) VALUES
(1, 'Teste');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `advogado`
--
ALTER TABLE `advogado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcionario` (`funcionario`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `processo`
--
ALTER TABLE `processo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advogado` (`advogado`),
  ADD KEY `cliente` (`cliente`),
  ADD KEY `vara` (`vara`);

--
-- Índices para tabela `reuniao`
--
ALTER TABLE `reuniao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advogado` (`advogado`),
  ADD KEY `cliente` (`cliente`),
  ADD KEY `processo` (`processo`);

--
-- Índices para tabela `vara`
--
ALTER TABLE `vara`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `advogado`
--
ALTER TABLE `advogado`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `processo`
--
ALTER TABLE `processo`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `reuniao`
--
ALTER TABLE `reuniao`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `vara`
--
ALTER TABLE `vara`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `advogado`
--
ALTER TABLE `advogado`
  ADD CONSTRAINT `advogado_ibfk_1` FOREIGN KEY (`funcionario`) REFERENCES `funcionario` (`id`);

--
-- Limitadores para a tabela `processo`
--
ALTER TABLE `processo`
  ADD CONSTRAINT `processo_ibfk_1` FOREIGN KEY (`advogado`) REFERENCES `advogado` (`id`),
  ADD CONSTRAINT `processo_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `processo_ibfk_3` FOREIGN KEY (`vara`) REFERENCES `vara` (`id`);

--
-- Limitadores para a tabela `reuniao`
--
ALTER TABLE `reuniao`
  ADD CONSTRAINT `reuniao_ibfk_1` FOREIGN KEY (`advogado`) REFERENCES `advogado` (`id`),
  ADD CONSTRAINT `reuniao_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `reuniao_ibfk_3` FOREIGN KEY (`processo`) REFERENCES `processo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
