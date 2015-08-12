<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"         => ":attribute должен быть принят.",
	"active_url"       => ":attribute не верный URL адрес.",
	"after"            => ":attribute должен быть датой позже :date.",
	"alpha"            => ":attribute должен содержать только символы.",
	"alpha_dash"       => ":attribute может содержать только буквы, цифры и тире.",
	"alpha_num"        => ":attribute может содержать только буквы и цифры.",
    "alpha_spaces"     => ":attribute может содержать только буквы и пробелы",
	"array"            => ":attribute должен быть массивом.",
	"before"           => ":attribute должен быть датой позже :date.",
	"between"          => array(
		"numeric" => ":attribute должен быть в диапазоне от :min до :max.",
		"file"    => ":attribute должен быть в диапазоне от :min до :max килобайт.",
		"string"  => ":attribute должен быть в диапазоне от :min до :max символов.",
		"array"   => ":attribute должен быть в диапазоне от :min до :max элементов.",
	),
	"confirmed"        => ":attribute не соотвествует подтверждению.",
	"date"             => ":attribute не верная дата.",
	"date_format"      => ":attribute не соотвествует формату :format.",
	"different"        => ":attribute и :other должны быть разными.",
	"digits"           => ":attribute должен быть :digits цифр.",
	"digits_between"   => ":attribute должен быть от :min до :max цифр.",
	"email"            => "Формат :attribute неверный.",
	"exists"           => "Выбранный :attribute неверный.",
	"image"            => ":attribute дожен быть изображением.",
	"in"               => "Выбранный :attribute неверный.",
	"integer"          => ":attribute должен быть целым числом.",
	"ip"               => ":attribute должен быть верным IP адресом.",
	"max"              => array(
		"numeric" => ":attribute не может быть более :max.",
		"file"    => ":attribute не может быть более :max килобайт.",
		"string"  => ":attribute не может быть более :max символов.",
		"array"   => ":attribute не может быть более :max элементов.",
	),
	"mimes"            => ":attribute должен быть файлом типа: :values.",
	"min"              => array(
		"numeric" => ":attribute должен быть хотя бы :min.",
		"file"    => ":attribute должен быть хотя бы :min килобайт.",
		"string"  => ":attribute должен быть хотя бы :min символов.",
		"array"   => ":attribute должен быть хотя бы :min элементов.",
	),
	"not_in"           => "Выбранный :attribute неверный.",
	"numeric"          => ":attribute должен быть числом.",
	"regex"            => "Неверный формат :attribute.",
	"required"         => "Обязательное поле :attribute.",
	"required_if"      => "Обязательное поле :attribute, когда :other имеет значение :value.",
	"required_with"    => "Обязательное поле :attribute когда :values заполнено.",
	"required_without" => "Обязательное поле :attribute когда :values не заполнено.",
	"same"             => ":attribute и :other должны совпадать.",
	"size"             => array(
		"numeric" => ":attribute должен быть :size.",
		"file"    => ":attribute должен быть :size килобайт.",
		"string"  => ":attribute должен быть :size символов.",
		"array"   => ":attribute должен содержать :size элементов.",
	),
	"unique"           => ":attribute уже занят.",
	"url"              => "Формат :attribute неверный.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),
    
    'errors' => 'Найдены ошибки при проверке.'

);
