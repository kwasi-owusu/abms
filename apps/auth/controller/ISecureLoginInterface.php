<?php

interface ISecureLoginInterface{
    public function is_login_has_valid(string $page_name, string $hash_key) : string;
}