<?php

namespace App\Helpers;

class Params
{
    const REGISTER_FEILDS = ['name', 'email', 'mobile', 'phone', 'password', 'client_type'];
    const LOGIN_FEILDS = ['username', 'password'];
    const RESET_PASSWORD_FEILDS = ['reset_payload', 'password'];
    const APP_FEILDS = ['name', 'description'];
    const VERSION_FEILDS = ['app_file', 'images', 'version', 'change_log', 'status'];
    const VERSION_MODIFY_FEILDS = ['app_file', 'images', 'change_log'];
}
