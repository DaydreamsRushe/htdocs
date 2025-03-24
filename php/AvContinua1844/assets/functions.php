<?php

function saneadoreitor($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}
