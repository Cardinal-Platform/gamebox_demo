CREATE DATABASE cardinal_game;
USE cardinal_game;

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `no` text NOT NULL,
  `name` text NOT NULL,
  `gender` int(11) NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `students` (`id`, `no`, `name`, `gender`, `phone`) VALUES
(1, '10000000', 'E99p1ant', 0, '13000000000'),
(2, '10000001', 'Cardinal', 0, '13800000000');

ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
