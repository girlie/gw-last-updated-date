<?php
/*
Name: Last Updated Date
Author: GirlieWorks, LLC
Description: Last Updated Date Box
Version: 1.2
Class: gwthesis_last_updated_date
*/

class gwthesis_last_updated_date extends thesis_box {
	protected function translate() {
		$this->title = __('Last Updated Date', $this->_class);
	}

	protected function html_options() {
		global $thesis;
		$html = $thesis->api->html_options();
		$html['class']['tooltip'] = sprintf(__('This box already contains a %1$s of <code>updated_post_date</code>. If you&#8217;d like to supply another %1$s, you can do that here.%2$s', $this->_class), $thesis->api->base['class'], $thesis->api->strings['class_note']);
		unset($html['id'], $html['class']);
		return array_merge($html, array(
			'format' => array(
				'type' => 'text',
				'width' => 'short',
				'code' => true,
				'label' => __('Updated Date Format', $this->_class),
				'tooltip' => $thesis->api->strings['date_tooltip'],
				'default' => get_option('date_format')),
			'intro' => array(
				'type' => 'text',
				'width' => 'short',
				'label' => __('Updated Date Intro Text', $this->_class),
				'tooltip' => sprintf(__('Any text you supply here will be wrapped in %s, like so:<br /><code>&lt;span class="post_date_intro"&gt</code>your text<code>&lt;/span&gt;</code>.', $this->_class), $thesis->api->base['html'])))
			);
	}

	public function html($args = array()) {
		global $thesis;
		extract($args = is_array($args) ? $args : array());
		$tab = str_repeat("\t", !empty($depth) ? $depth : 0);
		$time = get_the_time('Y-m-d');
		$format = strip_tags(!empty($this->options['format']) ?
			stripslashes($this->options['format']) :
			apply_filters("{$this->_class}_format", get_option('date_format')));
		if ( get_the_modified_date() != get_the_date() ) {
			echo
				(!empty($this->options['intro']) ?
				'<span class="updated_post_date_intro">'. $thesis->api->esch($this->options['intro']). '</span> ' : '').
				"<span class=\"updated_post_date". (!empty($this->options['class']) ? ' '. trim($thesis->api->esc($this->options['class'])) : ''). "\" title=\"$time\">".
				get_the_modified_date($format).
				"</span>\n";
		}
	}
}