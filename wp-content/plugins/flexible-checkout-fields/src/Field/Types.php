<?php

namespace WPDesk\FCF\Free\Field;

use WPDesk\FCF\Free\Field\Type\CheckboxDefaultType;
use WPDesk\FCF\Free\Field\Type\CheckboxType;
use WPDesk\FCF\Free\Field\Type\ColorType;
use WPDesk\FCF\Free\Field\Type\DateType;
use WPDesk\FCF\Free\Field\Type\DefaultType;
use WPDesk\FCF\Free\Field\Type\EmailType;
use WPDesk\FCF\Free\Field\Type\FileType;
use WPDesk\FCF\Free\Field\Type\HeadingType;
use WPDesk\FCF\Free\Field\Type\HtmlType;
use WPDesk\FCF\Free\Field\Type\ImageType;
use WPDesk\FCF\Free\Field\Type\MultiCheckboxType;
use WPDesk\FCF\Free\Field\Type\MultiSelectType;
use WPDesk\FCF\Free\Field\Type\NumberType;
use WPDesk\FCF\Free\Field\Type\ParagraphType;
use WPDesk\FCF\Free\Field\Type\PhoneType;
use WPDesk\FCF\Free\Field\Type\RadioColorsType;
use WPDesk\FCF\Free\Field\Type\RadioDefaultType;
use WPDesk\FCF\Free\Field\Type\RadioImagesType;
use WPDesk\FCF\Free\Field\Type\RadioType;
use WPDesk\FCF\Free\Field\Type\SelectType;
use WPDesk\FCF\Free\Field\Type\TextareaType;
use WPDesk\FCF\Free\Field\Type\TextType;
use WPDesk\FCF\Free\Field\Type\TimeType;
use WPDesk\FCF\Free\Field\Type\TypeIntegration;
use WPDesk\FCF\Free\Field\Type\UrlType;
use WPDesk\FCF\Free\Field\Type\Wc\WcAddress2Type;
use WPDesk\FCF\Free\Field\Type\Wc\WcContactType;
use WPDesk\FCF\Free\Field\Type\Wc\WcCountryType;
use WPDesk\FCF\Free\Field\Type\Wc\WcDefaultType;
use WPDesk\FCF\Free\Field\Type\Wc\WcNotesType;
use WPDesk\FCF\Free\Field\Type\Wc\WcPostcodeType;
use WPDesk\FCF\Free\Field\Type\Wc\WcStateType;

/**
 * Supports management for field types.
 */
class Types {

	const FIELD_GROUP_TEXT   = 'text';
	const FIELD_GROUP_OPTION = 'option';
	const FIELD_GROUP_PICKER = 'picker';
	const FIELD_GROUP_OTHER  = 'other';

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new TypeIntegration( new TextType() ) )->hooks();
		( new TypeIntegration( new TextareaType() ) )->hooks();
		( new TypeIntegration( new NumberType() ) )->hooks();
		( new TypeIntegration( new EmailType() ) )->hooks();
		( new TypeIntegration( new PhoneType() ) )->hooks();
		( new TypeIntegration( new UrlType() ) )->hooks();

		( new TypeIntegration( new CheckboxType() ) )->hooks();
		( new TypeIntegration( new MultiCheckboxType() ) )->hooks();
		( new TypeIntegration( new SelectType() ) )->hooks();
		( new TypeIntegration( new MultiSelectType() ) )->hooks();
		( new TypeIntegration( new RadioType() ) )->hooks();
		( new TypeIntegration( new RadioImagesType() ) )->hooks();
		( new TypeIntegration( new RadioColorsType() ) )->hooks();

		( new TypeIntegration( new ColorType() ) )->hooks();
		( new TypeIntegration( new DateType() ) )->hooks();
		( new TypeIntegration( new TimeType() ) )->hooks();
		( new TypeIntegration( new FileType() ) )->hooks();

		( new TypeIntegration( new HeadingType() ) )->hooks();
		( new TypeIntegration( new ParagraphType() ) )->hooks();
		( new TypeIntegration( new ImageType() ) )->hooks();
		( new TypeIntegration( new HtmlType() ) )->hooks();

		( new TypeIntegration( new DefaultType() ) )->hooks();
		( new TypeIntegration( new CheckboxDefaultType() ) )->hooks();
		( new TypeIntegration( new RadioDefaultType() ) )->hooks();
		( new TypeIntegration( new WcDefaultType() ) )->hooks();
		( new TypeIntegration( new WcContactType() ) )->hooks();
		( new TypeIntegration( new WcAddress2Type() ) )->hooks();
		( new TypeIntegration( new WcCountryType() ) )->hooks();
		( new TypeIntegration( new WcPostcodeType() ) )->hooks();
		( new TypeIntegration( new WcStateType() ) )->hooks();
		( new TypeIntegration( new WcNotesType() ) )->hooks();
	}
}
