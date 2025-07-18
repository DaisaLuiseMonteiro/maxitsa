<?php
namespace App\Core;

enum Validate : string {
   case IS_EMAIL = 'IS_EMAIL';
   case IS_EMPTY = 'IS_EMPTY';
   case IS_CNI = 'IS_CNI';
   case IS_TELEPHONE = 'IS_TELEPHONE';
   case IS_LENGTH = 'IS_LENGTH';
}