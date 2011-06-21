<?php

	if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");

	Class extension_mailchimp extends Extension{
	
		public function about(){
			return array('name' => 'MailChimp',
						 'version' => '1.13',
						 'release-date' => '2011-06-21',
						 'author' => array('name' => 'Mark Lewis',
										   'website' => 'http://www.casadelewis.com',
										   'email' => 'mark@casadelewis.com'),
						 'description' => 'Subscribe users to a MailChimp list.'
				 		);
		}
				
		public function uninstall() {
			Symphony::Configuration()->remove('mailchimp');
			Symphony::Configuration()->saveConfig();
		}
		
		public function getSubscribedDelegates() {
			return array(
				array(
					'page'		=> '/system/preferences/',
					'delegate'	=> 'AddCustomPreferenceFieldsets',
					'callback'	=> 'addCustomPreferenceFieldsets'
				)
			);
		}
		
	/*-------------------------------------------------------------------------
		Utilities:
	-------------------------------------------------------------------------*/
		
		public function getKey() {
			return Symphony::Configuration()->get('key', 'mailchimp');
		}
		
		public function getList() {
			return Symphony::Configuration()->get('list', 'mailchimp');
		}
		
	/*-------------------------------------------------------------------------
		Delegates:
	-------------------------------------------------------------------------*/
		
		public function addCustomPreferenceFieldsets($context) {
			$fieldset = new XMLElement('fieldset');
			$fieldset->setAttribute('class', 'settings');
			$fieldset->appendChild(
				new XMLElement('legend', 'Mailchimp')
			);
			
			$group = new XMLElement('div');
			$group->setAttribute('class', 'group');

			$api = Widget::Label('API Key');
			$api->appendChild(Widget::Input(
				'settings[mailchimp][key]', General::Sanitize($this->getKey())
			));
			$group->appendChild($api);
			
			$list = Widget::Label('List ID');
			$list->appendChild(Widget::Input(
				'settings[mailchimp][list]', General::Sanitize($this->getList())
			));
			$group->appendChild($list);

			$fieldset->appendChild($group);

			$context['wrapper']->appendChild($fieldset);			
		}
	}

?>