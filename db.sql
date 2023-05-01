RENAME TABLE `mipango`.`roles` TO `mipango`.`roles_`;
INSERT INTO `users` (`id`, `name`, `last_name`, `phone`, `gender`, `country`, `region`, `occupation`, `email`, `active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `updated_by`, `pwd_status`, `pwd_status_updated_at`, `last_login`, `last_psw_change`, `user_change_pwd`, `pwd_fail_count`, `pwd_last_fail_login`, `last_logon`, `pwd_last_time_change`, `user_role_id`, `facebook_id`, `profile_photo_url`, `google_id`, `dob`, `created_from`, `token`, `notification_status`, `morning_reminded_date`, `afternoon_reminded_date`, `evening_reminded_date`, `device_type`, `role_id`, `timezone_id`) VALUES (NULL, 'Lupenza', 'Lupenza', '0683130185', 'Male', 'Tanzania', NULL, NULL, 'admin@gmail.com', '1', NULL, '$2y$10$rgN7AZwbNezsKdITDqKZgOHPAJuHc5Qsc.akJMY49Kdu9FWqiuO2a\r\n',
ALTER TABLE `account_type` ADD `uuid` VARCHAR(100) NULL DEFAULT NULL AFTER `description`, ADD `created_by` INT NULL DEFAULT NULL AFTER `uuid`, ADD `updated_by` INT NULL DEFAULT NULL AFTER `created_by`;
ALTER TABLE `banks` ADD `created_by` INT NULL DEFAULT NULL AFTER `logo`, ADD `updated_by` INT NULL DEFAULT NULL AFTER `created_by`, ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by`, ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;
ALTER TABLE `banks` ADD `id` INT NOT NULL FIRST;
ALTER TABLE `banks` ADD `uuid_2` VARCHAR(100) NULL DEFAULT NULL AFTER `uuid`;
ALTER TABLE `category_groups` ADD `description` VARCHAR(100) NOT NULL AFTER `name`, ADD `created_by` INT NOT NULL AFTER `description`, ADD `updated_by` INT NULL DEFAULT NULL AFTER `created_by`, ADD `uuid` VARCHAR(100) NOT NULL AFTER `updated_by`, ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `uuid`, ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;
ALTER TABLE `categories` ADD `created_by` INT NOT NULL AFTER `icon_url`, ADD `updated_by` INT NULL DEFAULT NULL AFTER `created_by`, ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `updated_by`, ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;
ALTER TABLE `categories` CHANGE `category_group` `category_group` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '';
ALTER TABLE `users` ADD `uuid` VARCHAR(100) NULL DEFAULT NULL AFTER `timezone_id`;
INSERT INTO `permission_categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (NULL, 'User Permission', 'User permissions', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'Role permission', 'Role permissions', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);