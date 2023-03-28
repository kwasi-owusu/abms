<?php

interface ISecuredChangePassword{
    public function is_user_still_active(array $data, string $table_a) : int;
    public function change_user_password(string $table_a, string $table_b, array $data) : object;
}