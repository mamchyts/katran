<?php
/**
 * The file contains the system messages in several languages
 * 
 * @package     Config
 */

/**
 * Validator's messages
 * @see Validator()
 */
$msg['required']            = array('en' => 'The `%s` field is required',
                                    'ru' => 'Поле `%s` обязательно для заполнения');
$msg['isset']               = array('en' => 'The `%s` field must have a value',
                                    'ru' => 'Поле `%s` должно содержать значение');
$msg['email']               = array('en' => 'The `%s` field must contain a valid email address',
                                    'ru' => 'В поле `%s` должен быть введен корректный адрес электронной почты');
$msg['emails']              = array('en' => 'The `%s` field must contain all valid email addresses',
                                    'ru' => 'В поле `%s` должны быть введены корректные адреса электронной почты');
$msg['valid_url']           = array('en' => 'The `%s` field must contain a valid URL',
                                    'ru' => 'В поле `%s` должна содержаться корректная ссылка');
$msg['valid_ip']            = array('en' => 'The `%s` field must contain a valid IP',
                                    'ru' => 'В поле `%s` должен содержаться корректный IP');
$msg['min_length']          = array('en' => 'The `%s` field must be at least `%s` characters in length',
                                    'ru' => 'Длина поля `%s` должна быть не меньше `%s` символов');
$msg['max_length']          = array('en' => 'The `%s` field can not exceed `%s` characters in length',
                                    'ru' => 'Длина поля `%s` не может превышать `%s` символов');
$msg['exact_length']        = array('en' => 'The `%s` field must be exactly `%s` characters in length',
                                    'ru' => 'Длина поля `%s` должна быть равной `%s` символам');
$msg['alpha']               = array('en' => 'The `%s` field may only contain alphabetical characters',
                                    'ru' => 'Поле `%s` может содержать только символы алфавита');
$msg['alpha_numeric']       = array('en' => 'The `%s` field may only contain alpha-numeric characters',
                                    'ru' => 'Поле `%s` может содержать только символы алфавита и цифры');
$msg['alpha_dash']          = array('en' => 'The `%s` field may only contain alpha-numeric characters, underscores, and dashes',
                                    'ru' => 'Поле `%s` может содержать только символы алфавита и цифры, подчеркивания и тире');
$msg['numeric']             = array('en' => 'The `%s` field must contain only numbers',
                                    'ru' => 'Поле `%s` должно содержать только цифры');
$msg['is_numeric']          = array('en' => 'The `%s` field must contain only numeric characters',
                                    'ru' => 'Поле `%s` должно содержать только числовые символы');
$msg['integer']             = array('en' => 'The `%s` field must contain an integer',
                                    'ru' => 'Поле `%s` должно содержать целое число');
$msg['regex_match']         = array('en' => 'The `%s` field is not in the correct format',
                                    'ru' => 'Значение поля `%s` имеет неверный формат');
$msg['match']               = array('en' => 'The `%s` field does not match the `%s` field',
                                    'ru' => 'Значение поля `%s` не совпадает со значением поля `%s`');
$msg['is_natural']          = array('en' => 'The `%s` field must contain only positive numbers',
                                    'ru' => 'Поле `%s` должно содержать только положительные числа');
$msg['is_natural_no_zero']  = array('en' => 'The `%s` field must contain a number greater than zero',
                                    'ru' => 'Поле `%s` должно содержать число больше нуля');
$msg['decimal']             = array('en' => 'The `%s` field must contain a decimal number',
                                    'ru' => 'Поле `%s` должно содержать только десятичные числа');
$msg['less_than']           = array('en' => 'The `%s` field must contain a number less than `%s`',
                                    'ru' => 'Поле `%s` должно содержать число меньше чем `%s`');
$msg['more_than']           = array('en' => 'The `%s` field must contain a number greater than `%s`',
                                    'ru' => 'Поле `%s` должно содержать число больше чем `%s`');
$msg['time']                = array('en' => 'The `%s` is not a time-stamped',
                                    'ru' => 'Поле `%s` не является временной отметкой');
$msg['lang']                = array('en' => 'en',
                                    'ru' => 'ru');


/**
 * Other messages
 */
$msg['ok']                  = array('en' => 'The operation successfully performed',
                                    'ru' => 'Операция успешно проведена');
$msg['error']               = array('en' => 'System Error. Try again',
                                    'ru' => 'Произошла ошибка');
$msg['login_error']         = array('en' => 'You have entered an incorrect username or password',
                                    'ru' => 'Неверное имя пользователя или пароль');
$msg['blocked_account']     = array('en' => 'User account is blocked',
                                    'ru' => 'Пользователь заблокирован, обратитесь к администратору');
$msg['access_denied']       = array('en' => 'You can\'t access rights for this operation',
                                    'ru' => 'У вас недостаточно прав для проведения данной операции');
$msg['mysql']               = array('en' => 'Mysql error: `%s`',
                                    'ru' => 'Mysql error: `%s`');

// need for get array
return $msg;