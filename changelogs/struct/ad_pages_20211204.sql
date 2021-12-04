ALTER TABLE `n8_page`.`ad_pages`
    ADD COLUMN `structure_version` varchar(255) NOT NULL COMMENT '构建版本' AFTER `admin_id`;
