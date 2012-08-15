<?php
view::$title = "GetYourVenue.com - CMS";
view::$keywords = "GetYourVenue.com - CMS";
view::$description = "";
switch($requestedPage){
  case 'home':
    view::$title .= " - Home";
    break;
  case 'readerscorner':
    view::$title .= " - Readers Corner";
  break;
  case 'alliedservices':
    view::$title .= " - Allied Services";
  break;
  case 'leads':
    view::$title .= " - Leads";
  break;
  case 'venue':
    view::$title .= " - VENUE";
    break;
  case 'adminusers':
    view::$title .= " CMS Admin Users";
    break;
  default:
    break;
}
