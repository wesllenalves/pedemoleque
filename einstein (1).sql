-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18-Jun-2018 às 19:50
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `einstein`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nomeCliente` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(128) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `dataNas` date NOT NULL,
  `celular` varchar(45) NOT NULL,
  `telefoneFixo` varchar(255) DEFAULT NULL,
  `tipoUsuario` varchar(255) NOT NULL DEFAULT '0',
  `dataCadas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nomeCliente`, `email`, `senha`, `salt`, `cpf`, `dataNas`, `celular`, `telefoneFixo`, `tipoUsuario`, `dataCadas`) VALUES
(1, 'wesllen alves de sousa', 'wesllenalves@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '$2y$10$LlVbMlVgENMGIkUU49WbD.6NSxe4uh4Zby66CE2vwaM0GuxwMHsr2', '03230944143', '1993-09-24', '61981745695', '61981745695', 'admin', '2018-05-31 20:15:08'),
(3, 'wesllen alves de sousa', 'cliente@cliente.com', 'e10adc3949ba59abbe56e057f20f883e', '$2y$10$HK.jg4eXIy.gH7dNXG3Gs.vbQw6UpTBMmkO8EniLI158lCSQLa5ja', '03230944150', '2018-06-01', '61981745695', '61981745695', 'comun', '2018-06-10 13:08:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `complemento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id`, `cliente_id`, `cep`, `rua`, `bairro`, `cidade`, `estado`, `complemento`) VALUES
(1, 1, '70645160', 'SRES Quadra 10 Bloco P', 'Cruzeiro Velho', 'Brasília', 'DF', 'Green park'),
(3, 3, '70645160', 'SRES Quadra 10 Bloco P', 'Cruzeiro Velho', 'Brasília', 'DF', 'Green park');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `nomeFornecedor` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `DataModificado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `user_id`, `cnpj`, `nomeFornecedor`, `telefone`, `email`, `DataModificado`) VALUES
(3, 1, '1111111', 'havaiannas', '61981745695', 'wesllenalves@gmail.com', '2018-06-02 00:00:00'),
(4, 6, '1111111111', 'lavem elas', '61981745695', 'teste@com', '2018-06-09 00:00:00'),
(5, 10, '111141', 'wesllen alves de sousa', '61981745695', 'wesllenalves@gmail.com', '2018-06-02 17:55:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `idFuncionario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `telefoneCelular` varchar(255) NOT NULL,
  `telefoneFixo` varchar(255) NOT NULL,
  `dataNascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`idFuncionario`, `nome`, `rg`, `email`, `senha`, `telefoneCelular`, `telefoneFixo`, `dataNascimento`) VALUES
(1, 'wesllen', '297145', 'wesllenalves@gmail.com', '123456', '6198174595', '30459780', '2018-04-19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario_projeto`
--

CREATE TABLE `funcionario_projeto` (
  `FKFuncionario` int(11) NOT NULL,
  `FKProjeto` int(11) NOT NULL,
  `nomeFase` varchar(255) NOT NULL,
  `dataInicialFase` date NOT NULL,
  `dataFinalFase` date NOT NULL,
  `statusFase` int(1) NOT NULL,
  `observacaoFase` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nomeProduto` varchar(255) NOT NULL,
  `descricaoProduto` text NOT NULL,
  `qtdEstoque` int(11) NOT NULL,
  `valor` decimal(18,2) NOT NULL,
  `fotoProduto` varchar(255) DEFAULT NULL,
  `DataModificado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `nomeProduto`, `descricaoProduto`, `qtdEstoque`, `valor`, `fotoProduto`, `DataModificado`) VALUES
(1, 'tennis', '', 10, '25.00', 'tenis-nike-air-behold-low-masculino.jpg', '2018-05-28 21:26:42'),
(2, 'sapatennis', 'um confortÃ¡vel sapato para o verao', 10, '80.00', 'main-product01.jpg', '0000-00-00 00:00:00'),
(6, 'chinela', 'uma pequena chinela', 200, '50.00', 'chinela.jpg', '0000-00-00 00:00:00'),
(7, 'tennis', 'um tenis bom', 20, '25.00', NULL, '0000-00-00 00:00:00'),
(8, 'wesllen', '12233', 20, '200.00', 'a68ace90c94807cac654bd39cbb268fb.jpg', '2018-06-02 17:50:13'),
(9, 'wesllen', '12233', 20, '200.00', 'bcc89babb7c2db837b82b6559e4a90a6.jpg', '2018-06-02 17:51:48'),
(10, 'wesllen', '12233', 20, '200.00', 'd5a78013c99486ff979a969abc31a4e9.jpg', '2018-06-02 17:55:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `id` int(11) NOT NULL,
  `nomeProjeto` varchar(255) NOT NULL,
  `descricaoProjeto` text NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `statusProjeto` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recoveries`
--

CREATE TABLE `recoveries` (
  `idpassword` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `idroles` int(11) NOT NULL,
  `role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`idroles`, `role`) VALUES
(1, 'Admin'),
(2, 'Users');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `idusers` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cpf` varchar(255) NOT NULL,
  `dataNasc` date NOT NULL,
  `dataCad` datetime NOT NULL,
  `salt` char(128) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`idusers`, `nome`, `email`, `senha`, `cpf`, `dataNasc`, `dataCad`, `salt`, `role_id`, `status`) VALUES
(2, 'wesllen alves de sousa', 'wesllenalves@gmail.com', 'MTIzNDU2', '03230944143', '1993-09-24', '2018-04-02 17:16:53', '$2y$10$PmE7iiQOPU6/tSoOHLdq.eGNCfzZGsdFGb42/M8rjd9dC5rBnEb4C', 2, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nomeProduto` varchar(255) NOT NULL,
  `valorTotal` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dataVenda` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente_constrainer` (`cliente_id`);

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_constrainer` (`user_id`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`idFuncionario`);

--
-- Indexes for table `funcionario_projeto`
--
ALTER TABLE `funcionario_projeto`
  ADD PRIMARY KEY (`FKFuncionario`,`FKProjeto`),
  ADD KEY `fk_funcionario_has_projeto_projeto1_idx` (`FKProjeto`),
  ADD KEY `fk_funcionario_has_projeto_funcionario_idx` (`FKFuncionario`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_attempts_user_id` (`user_id`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recoveries`
--
ALTER TABLE `recoveries`
  ADD PRIMARY KEY (`idpassword`),
  ADD KEY `password_user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idroles`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idusers`),
  ADD KEY `roles_role_id` (`role_id`);

--
-- Indexes for table `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKVENDAS_IDCLIENTE` (`id_cliente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `idFuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recoveries`
--
ALTER TABLE `recoveries`
  MODIFY `idpassword` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idusers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `id_cliente_constrainer` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD CONSTRAINT `id_user_constrainer` FOREIGN KEY (`user_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `funcionario_projeto`
--
ALTER TABLE `funcionario_projeto`
  ADD CONSTRAINT `fk_funcionario_has_projeto_funcionario` FOREIGN KEY (`FKFuncionario`) REFERENCES `funcionario` (`idFuncionario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_funcionario_has_projeto_projeto1` FOREIGN KEY (`FKProjeto`) REFERENCES `projeto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `login_attempts_user_id` FOREIGN KEY (`user_id`) REFERENCES `cliente` (`id`);

--
-- Limitadores para a tabela `recoveries`
--
ALTER TABLE `recoveries`
  ADD CONSTRAINT `password_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `roles_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`idroles`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `FKVENDAS_IDCLIENTE` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
