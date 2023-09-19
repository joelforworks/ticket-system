<?php
  
namespace App\Enums;
 
enum TicketPriority:string {
    case Low = 'low';
    case Mid = 'mid';
    case High = 'high';
}
