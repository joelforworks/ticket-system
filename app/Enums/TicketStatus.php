<?php
  
namespace App\Enums;
 
enum TicketStatus:string {
    case Open = 'open';
    case Close = 'close';
}
