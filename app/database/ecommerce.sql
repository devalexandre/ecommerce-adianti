-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 172.17.0.2
-- Generation Time: 01-Maio-2017 às 14:59
-- Versão do servidor: 10.1.22-MariaDB-1~jessie
-- PHP Version: 7.0.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Adianti Framework Ebooks', '<p>livros sobre adianti framework</p>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `custumers`
--

CREATE TABLE `custumers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `avatar` text,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `custumers`
--

INSERT INTO `custumers` (`id`, `name`, `email`, `avatar`, `password`) VALUES
(1, NULL, 'alexandre@indev.net.br', NULL, '2a4860a1888726c85345ed9fe9c5bfd0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

CREATE TABLE `imagens` (
  `id` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `src` text,
  `products_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `imagens`
--

INSERT INTO `imagens` (`id`, `position`, `src`, `products_id`) VALUES
(1, 1, 'medium.png', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `payament`
--

CREATE TABLE `payament` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `token` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `price` decimal(15,2) DEFAULT NULL,
  `categories_id` int(11) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `categories_id`, `featured`) VALUES
(1, 'Desenvimentod e Ecommerce com Adianti framework', 'Desenvimentod e Ecommerce com Adianti framework', 50.00, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products_requests`
--

CREATE TABLE `products_requests` (
  `id` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  `products_id` int(11) NOT NULL,
  `requests_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `products_requests`
--

INSERT INTO `products_requests` (`id`, `qty`, `products_id`, `requests_id`) VALUES
(1, 1, 1, 1),
(2, 3, 1, 2),
(3, 1, 1, 3),
(4, 1, 1, 4),
(5, 1, 1, 5),
(6, 1, 1, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `custumers_id` int(11) NOT NULL,
  `transaction_id` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `requests`
--

INSERT INTO `requests` (`id`, `total`, `status`, `custumers_id`, `transaction_id`) VALUES
(1, 50.00, 'Aguardando pagamento', 1, NULL),
(2, 150.00, 'Aguardando pagamento', 1, '4EDC69BC-E8A4-4B26-89DD-ADF299463A20'),
(3, 50.00, 'Aguardando pagamento', 1, NULL),
(4, 50.00, 'Aguardando pagamento', 1, NULL),
(5, 50.00, 'Aguardando pagamento', 1, NULL),
(6, 50.00, 'Aguardando pagamento', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custumers`
--
ALTER TABLE `custumers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`);

--
-- Indexes for table `payament`
--
ALTER TABLE `payament`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_id` (`categories_id`);

--
-- Indexes for table `products_requests`
--
ALTER TABLE `products_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`),
  ADD KEY `requests_id` (`requests_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custumers_id` (`custumers_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `custumers`
--
ALTER TABLE `custumers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `payament`
--
ALTER TABLE `payament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products_requests`
--
ALTER TABLE `products_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `imagens`
--
ALTER TABLE `imagens`
  ADD CONSTRAINT `imagens_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`);

--
-- Limitadores para a tabela `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`);

--
-- Limitadores para a tabela `products_requests`
--
ALTER TABLE `products_requests`
  ADD CONSTRAINT `products_requests_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `products_requests_ibfk_2` FOREIGN KEY (`requests_id`) REFERENCES `requests` (`id`);

--
-- Limitadores para a tabela `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`custumers_id`) REFERENCES `custumers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
