<?php

namespace silici0\RDStation\Exceptions;

use Exception;

class ErrorControl extends Exception
{
	public static function notAutenticaded()
	{
		return new static('É necessário fazer autenticação para obter o token de acesso antes de poder usar a API');
	}

	public static function erroMsg($msg)
	{
		return new static($msg);
	}
}