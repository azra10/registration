<?php

function iss_current_user_can_admin(){ return current_user_can ( 'iss_admin' ); }
function iss_current_user_on_board(){ return current_user_can ( 'iss_board' ); }
function iss_current_user_is_secretery(){ return current_user_can ( 'iss_secretary' ); }
function iss_current_user_can_runtest(){ return current_user_can ( 'iss_test' ); }

?>