<?php 
namespace App\Enums;
enum TicketStatus:string
{
    case OPEN='open';
    case RESOLVED='approved';
    case REJECTED='rejected';
}