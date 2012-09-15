<?php

function au_random_content_init(){
	elgg_register_widget_type('au_random_content', elgg_echo('au_random_content'), elgg_echo('au_random_content:widget:description'), 'all,groups,index', TRUE);
}

elgg_register_event_handler("init", "system", "au_random_content_init");