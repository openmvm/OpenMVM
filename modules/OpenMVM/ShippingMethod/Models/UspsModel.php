<?php

namespace Modules\OpenMVM\ShippingMethod\Models;

class UspsModel extends \CodeIgniter\Model
{
	public function __construct()
	{
		// Load Libraries
		$this->setting = new \App\Libraries\Setting;
		$this->language = new \App\Libraries\Language;
		$this->currency = new \App\Libraries\Currency;
		$this->weight = new \App\Libraries\Weight;
		$this->length = new \App\Libraries\Length;
		// Load Modules Libraries
		$this->cart = new \Modules\OpenMVM\Order\Libraries\Cart;
		// Load Database
		$this->db = db_connect();
	}

	public function getQuote($store_id, $shipping_address_id, $user_id)
	{
		$quote_data = array();

		// Get address info
		$builder_user_address = $this->db->table('user_address');
		$builder_user_address->where('user_address_id', $shipping_address_id);
		$builder_user_address->where('user_id', $user_id);

		$query_user_address   = $builder_user_address->get();

		$address = $query_user_address->getRow();

		// Get state to origin geo zone
		$builder_state_to_origin_geo_zone = $this->db->table('state_to_geo_zone');
		$builder_state_to_origin_geo_zone->where('geo_zone_id', $this->setting->get('shipping_usps', 'shipping_usps_origin_geo_zone_id'));
		$builder_state_to_origin_geo_zone->where('country_id', $address->country_id);
		$builder_state_to_origin_geo_zone->groupStart();
		$builder_state_to_origin_geo_zone->where('state_id', $address->state_id);
		$builder_state_to_origin_geo_zone->orWhere('state_id', 0);
		$builder_state_to_origin_geo_zone->groupEnd();

		$total_origin_geo_zone_results = $builder_state_to_origin_geo_zone->countAllResults();

		// Get state to destination geo zone
		$builder_state_to_destination_geo_zone = $this->db->table('state_to_geo_zone');
		$builder_state_to_destination_geo_zone->where('geo_zone_id', $this->setting->get('shipping_usps', 'shipping_usps_destination_geo_zone_id'));
		$builder_state_to_destination_geo_zone->where('country_id', $address->country_id);
		$builder_state_to_destination_geo_zone->groupStart();
		$builder_state_to_destination_geo_zone->where('state_id', $address->state_id);
		$builder_state_to_destination_geo_zone->orWhere('state_id', 0);
		$builder_state_to_destination_geo_zone->groupEnd();

		$total_destination_geo_zone_results = $builder_state_to_destination_geo_zone->countAllResults();

		if (empty($this->setting->get('shipping_usps', 'shipping_usps_origin_geo_zone_id')) && empty($this->setting->get('shipping_usps', 'shipping_usps_destination_geo_zone_id'))) {
			$status = true;
		} elseif ($total_origin_geo_zone_results > 0 && $total_destination_geo_zone_results > 0) {
			$status = true;
		} else {
			$status = false;
		}

		$weight = $this->weight->convert($this->cart->getWeight($store_id), $this->setting->get('setting', 'setting_frontend_weight_class_id'), $this->setting->get('shipping_usps', 'shipping_usps_weight_class_id'));
		
		// 70 pound limit
		if ($weight > 70) {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			// Get store info
			$builder_store = $this->db->table('store');
			$builder_store->where('store_id', $store_id);

			$query_store   = $builder_store->get();

			$row_store = $query_store->getRow();

			// Get store user/owner
			$builder_store_owner = $this->db->table('user');
			$builder_store_owner->where('user_id', $row_store->user_id);

			$query_store_owner = $builder_store_owner->get();

			$row_store_owner = $query_store_owner->getRow();

			// Get country origin info
			$builder_country_origin = $this->db->table('country');
			$builder_country_origin->where('country_id', $row_store->shipping_origin_country_id);

			$query_country_origin = $builder_country_origin->get();

			$row_country_origin = $query_country_origin->getRow();

			// Get state origin info
			$builder_state_origin = $this->db->table('state');
			$builder_state_origin->where('state_id', $row_store->shipping_origin_state_id);

			$query_state_origin = $builder_state_origin->get();

			$row_state_origin = $query_state_origin->getRow();

			// Get country destination info
			$builder_country_destination = $this->db->table('country');
			$builder_country_destination->where('country_id', $address->country_id);

			$query_country_destination = $builder_country_destination->get();

			$row_country_destination = $query_country_destination->getRow();

			// Get state destination info
			$builder_state_destination = $this->db->table('state');
			$builder_state_destination->where('state_id', $address->state_id);

			$query_state_destination = $builder_state_destination->get();

			$row_state_destination = $query_state_destination->getRow();

			$quote_data = array();

			$weight = ($weight < 0.1 ? 0.1 : $weight);
			$pounds = floor($weight);
			$ounces = round(16 * ($weight - $pounds), 2); // max 5 digits

			$postcode = str_replace(' ', '', $address->postal_code);

			// Length
			$default_length_unit = $this->length->getUnit($this->setting->get('shipping_usps', 'shipping_usps_length_class_id'));

			$vendor_length_unit = $this->length->getUnit($this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_length_class_id'));

			$vendor_package_dimension_length = $this->length->getUnit($this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_package_dimension_length'));
			$vendor_package_dimension_width = $this->length->getUnit($this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_package_dimension_width'));
			$vendor_package_dimension_height = $this->length->getUnit($this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_package_dimension_height'));

			$length = $this->length->convert($package_dimension_length, $vendor_length_unit, $default_length_unit);
			$width = $this->length->convert($package_dimension_width, $vendor_length_unit, $default_length_unit);
			$height = $this->length->convert($package_dimension_height, $vendor_length_unit, $default_length_unit);

			if ($row_country_destination->iso_code_2 == 'US') {
				$xml  = '<RateV4Request USERID="' . $this->setting->get('shipping_usps', 'shipping_usps_user_id') . '">';
				$xml .= '	<Package ID="1">';
				$xml .=	'		<Service>ALL</Service>';
				$xml .=	'		<ZipOrigination>' . substr($row_store->shipping_origin_postal_code, 0, 5) . '</ZipOrigination>';
				$xml .=	'		<ZipDestination>' . substr($postcode, 0, 5) . '</ZipDestination>';
				$xml .=	'		<Pounds>' . $pounds . '</Pounds>';
				$xml .=	'		<Ounces>' . $ounces . '</Ounces>';

				// Prevent common size mismatch error from USPS (Size cannot be Regular if Container is Rectangular for some reason)
				if ($this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_container') == 'RECTANGULAR' && $this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_size') == 'REGULAR') {
					$shipping_usps_container = 'VARIABLE';
				}

				$xml .=	'		<Container>' . $this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_container') . '</Container>';
				$xml .=	'		<Size>' . $this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_size') . '</Size>';
				$xml .= '		<Width>' . $width . '</Width>';
				$xml .= '		<Length>' . $length . '</Length>';
				$xml .= '		<Height>' . $height . '</Height>';

				// Calculate girth based on usps calculation
				$xml .= '		<Girth>' . (round(((float)$length + (float)$width * 2 + (float)$height * 2), 1)) . '</Girth>';
				$xml .=	'		<Machinable>' . ($this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_machinable') ? 'true' : 'false') . '</Machinable>';
				$xml .=	'	</Package>';
				$xml .= '</RateV4Request>';

				$request = 'API=RateV4&XML=' . urlencode($xml);
			} else {
				$country = array(
					'AF' => 'Afghanistan',
					'AL' => 'Albania',
					'DZ' => 'Algeria',
					'AD' => 'Andorra',
					'AO' => 'Angola',
					'AI' => 'Anguilla',
					'AG' => 'Antigua and Barbuda',
					'AR' => 'Argentina',
					'AM' => 'Armenia',
					'AW' => 'Aruba',
					'AU' => 'Australia',
					'AT' => 'Austria',
					'AZ' => 'Azerbaijan',
					'BS' => 'Bahamas',
					'BH' => 'Bahrain',
					'BD' => 'Bangladesh',
					'BB' => 'Barbados',
					'BY' => 'Belarus',
					'BE' => 'Belgium',
					'BZ' => 'Belize',
					'BJ' => 'Benin',
					'BM' => 'Bermuda',
					'BT' => 'Bhutan',
					'BO' => 'Bolivia',
					'BA' => 'Bosnia-Herzegovina',
					'BW' => 'Botswana',
					'BR' => 'Brazil',
					'VG' => 'British Virgin Islands',
					'BN' => 'Brunei Darussalam',
					'BG' => 'Bulgaria',
					'BF' => 'Burkina Faso',
					'MM' => 'Burma',
					'BI' => 'Burundi',
					'KH' => 'Cambodia',
					'CM' => 'Cameroon',
					'CA' => 'Canada',
					'CV' => 'Cape Verde',
					'KY' => 'Cayman Islands',
					'CF' => 'Central African Republic',
					'TD' => 'Chad',
					'CL' => 'Chile',
					'CN' => 'China',
					'CX' => 'Christmas Island (Australia)',
					'CC' => 'Cocos Island (Australia)',
					'CO' => 'Colombia',
					'KM' => 'Comoros',
					'CG' => 'Congo (Brazzaville),Republic of the',
					'ZR' => 'Congo, Democratic Republic of the',
					'CK' => 'Cook Islands (New Zealand)',
					'CR' => 'Costa Rica',
					'CI' => 'Cote d\'Ivoire (Ivory Coast)',
					'HR' => 'Croatia',
					'CU' => 'Cuba',
					'CY' => 'Cyprus',
					'CZ' => 'Czech Republic',
					'DK' => 'Denmark',
					'DJ' => 'Djibouti',
					'DM' => 'Dominica',
					'DO' => 'Dominican Republic',
					'TP' => 'East Timor (Indonesia)',
					'EC' => 'Ecuador',
					'EG' => 'Egypt',
					'SV' => 'El Salvador',
					'GQ' => 'Equatorial Guinea',
					'ER' => 'Eritrea',
					'EE' => 'Estonia',
					'ET' => 'Ethiopia',
					'FK' => 'Falkland Islands',
					'FO' => 'Faroe Islands',
					'FJ' => 'Fiji',
					'FI' => 'Finland',
					'FR' => 'France',
					'GF' => 'French Guiana',
					'PF' => 'French Polynesia',
					'GA' => 'Gabon',
					'GM' => 'Gambia',
					'GE' => 'Georgia, Republic of',
					'DE' => 'Germany',
					'GH' => 'Ghana',
					'GI' => 'Gibraltar',
					'GB' => 'Great Britain and Northern Ireland',
					'GR' => 'Greece',
					'GL' => 'Greenland',
					'GD' => 'Grenada',
					'GP' => 'Guadeloupe',
					'GT' => 'Guatemala',
					'GN' => 'Guinea',
					'GW' => 'Guinea-Bissau',
					'GY' => 'Guyana',
					'HT' => 'Haiti',
					'HN' => 'Honduras',
					'HK' => 'Hong Kong',
					'HU' => 'Hungary',
					'IS' => 'Iceland',
					'IN' => 'India',
					'ID' => 'Indonesia',
					'IR' => 'Iran',
					'IQ' => 'Iraq',
					'IE' => 'Ireland',
					'IL' => 'Israel',
					'IT' => 'Italy',
					'JM' => 'Jamaica',
					'JP' => 'Japan',
					'JO' => 'Jordan',
					'KZ' => 'Kazakhstan',
					'KE' => 'Kenya',
					'KI' => 'Kiribati',
					'KW' => 'Kuwait',
					'KG' => 'Kyrgyzstan',
					'LA' => 'Laos',
					'LV' => 'Latvia',
					'LB' => 'Lebanon',
					'LS' => 'Lesotho',
					'LR' => 'Liberia',
					'LY' => 'Libya',
					'LI' => 'Liechtenstein',
					'LT' => 'Lithuania',
					'LU' => 'Luxembourg',
					'MO' => 'Macao',
					'MK' => 'Macedonia, Republic of',
					'MG' => 'Madagascar',
					'MW' => 'Malawi',
					'MY' => 'Malaysia',
					'MV' => 'Maldives',
					'ML' => 'Mali',
					'MT' => 'Malta',
					'MQ' => 'Martinique',
					'MR' => 'Mauritania',
					'MU' => 'Mauritius',
					'YT' => 'Mayotte (France)',
					'MX' => 'Mexico',
					'MD' => 'Moldova',
					'MC' => 'Monaco (France)',
					'MN' => 'Mongolia',
					'MS' => 'Montserrat',
					'MA' => 'Morocco',
					'MZ' => 'Mozambique',
					'NA' => 'Namibia',
					'NR' => 'Nauru',
					'NP' => 'Nepal',
					'NL' => 'Netherlands',
					'AN' => 'Netherlands Antilles',
					'NC' => 'New Caledonia',
					'NZ' => 'New Zealand',
					'NI' => 'Nicaragua',
					'NE' => 'Niger',
					'NG' => 'Nigeria',
					'KP' => 'North Korea (Korea, Democratic People\'s Republic of)',
					'NO' => 'Norway',
					'OM' => 'Oman',
					'PK' => 'Pakistan',
					'PA' => 'Panama',
					'PG' => 'Papua New Guinea',
					'PY' => 'Paraguay',
					'PE' => 'Peru',
					'PH' => 'Philippines',
					'PN' => 'Pitcairn Island',
					'PL' => 'Poland',
					'PT' => 'Portugal',
					'QA' => 'Qatar',
					'RE' => 'Reunion',
					'RO' => 'Romania',
					'RU' => 'Russia',
					'RW' => 'Rwanda',
					'SH' => 'Saint Helena',
					'KN' => 'Saint Kitts (St. Christopher and Nevis)',
					'LC' => 'Saint Lucia',
					'PM' => 'Saint Pierre and Miquelon',
					'VC' => 'Saint Vincent and the Grenadines',
					'SM' => 'San Marino',
					'ST' => 'Sao Tome and Principe',
					'SA' => 'Saudi Arabia',
					'SN' => 'Senegal',
					'YU' => 'Serbia-Montenegro',
					'SC' => 'Seychelles',
					'SL' => 'Sierra Leone',
					'SG' => 'Singapore',
					'SK' => 'Slovak Republic',
					'SI' => 'Slovenia',
					'SB' => 'Solomon Islands',
					'SO' => 'Somalia',
					'ZA' => 'South Africa',
					'GS' => 'South Georgia (Falkland Islands)',
					'KR' => 'South Korea (Korea, Republic of)',
					'ES' => 'Spain',
					'LK' => 'Sri Lanka',
					'SD' => 'Sudan',
					'SR' => 'Suriname',
					'SZ' => 'Swaziland',
					'SE' => 'Sweden',
					'CH' => 'Switzerland',
					'SY' => 'Syrian Arab Republic',
					'TW' => 'Taiwan',
					'TJ' => 'Tajikistan',
					'TZ' => 'Tanzania',
					'TH' => 'Thailand',
					'TG' => 'Togo',
					'TK' => 'Tokelau (Union) Group (Western Samoa)',
					'TO' => 'Tonga',
					'TT' => 'Trinidad and Tobago',
					'TN' => 'Tunisia',
					'TR' => 'Turkey',
					'TM' => 'Turkmenistan',
					'TC' => 'Turks and Caicos Islands',
					'TV' => 'Tuvalu',
					'UG' => 'Uganda',
					'UA' => 'Ukraine',
					'AE' => 'United Arab Emirates',
					'UY' => 'Uruguay',
					'UZ' => 'Uzbekistan',
					'VU' => 'Vanuatu',
					'VA' => 'Vatican City',
					'VE' => 'Venezuela',
					'VN' => 'Vietnam',
					'WF' => 'Wallis and Futuna Islands',
					'WS' => 'Western Samoa',
					'YE' => 'Yemen',
					'ZM' => 'Zambia',
					'ZW' => 'Zimbabwe'
				);

				if (isset($country[$row_country_destination->iso_code_2])) {
					$xml  = '<IntlRateV2Request USERID="' . $this->setting->get('shipping_usps', 'shipping_usps_user_id') . '">';
					$xml .= '	<Revision>2</Revision>';
					$xml .=	'	<Package ID="1">';
					$xml .=	'		<Pounds>' . $pounds . '</Pounds>';
					$xml .=	'		<Ounces>' . $ounces . '</Ounces>';
					$xml .=	'		<MailType>All</MailType>';
					$xml .=	'		<GXG>';
					$xml .=	'		  <POBoxFlag>N</POBoxFlag>';
					$xml .=	'		  <GiftFlag>N</GiftFlag>';
					$xml .=	'		</GXG>';
					$xml .=	'		<ValueOfContents>' . $this->cart->getSubTotal($store_id) . '</ValueOfContents>';
					$xml .=	'		<Country>' . $country[$row_country_destination->iso_code_2] . '</Country>';

					// Intl only supports RECT and NONRECT
					if ($this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_container') == 'VARIABLE') {
						$shipping_usps_container = 'NONRECTANGULAR';
					}

					$xml .=	'		<Container>' . $shipping_usps_container . '</Container>';
					$xml .=	'		<Size>' . $this->setting->get('vendor_' . $store_id . '_shipping_usps', 'vendor_' . $store_id . '_shipping_usps_size') . '</Size>';
					$xml .= '		<Width>' . $width . '</Width>';
					$xml .= '		<Length>' . $length . '</Length>';
					$xml .= '		<Height>' . $height . '</Height>';

					// Calculate girth based on usps calculation
					$xml .= '		<Girth>' . (round(((float)$length + (float)$width * 2 + (float)$height * 2), 1)) . '</Girth>';
					$xml .= '		<OriginZip>' . substr($row_store->shipping_origin_postal_code, 0, 5) . '</OriginZip>';
					$xml .= '		<CommercialFlag>N</CommercialFlag>';
					$xml .=	'	</Package>';
					$xml .=	'</IntlRateV2Request>';

					$request = 'API=IntlRateV2&XML=' . urlencode($xml);
				} else {
					$status = false;
				}
			}

			if ($status) {
				$curl = curl_init();

				curl_setopt($curl, CURLOPT_URL, 'production.shippingapis.com/ShippingAPI.dll?' . $request);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

				$result = curl_exec($curl);

				curl_close($curl);

				// strip reg, trade and ** out, updated 9-11-2013
				$result = str_replace('&amp;lt;sup&amp;gt;&amp;#174;&amp;lt;/sup&amp;gt;', '', $result);
				$result = str_replace('&amp;lt;sup&amp;gt;&amp;#8482;&amp;lt;/sup&amp;gt;', '', $result);
				$result = str_replace('&amp;lt;sup&amp;gt;&amp;#174;&amp;lt;/sup&amp;gt;', '', $result);

				$result = str_replace('**', '', $result);
				$result = str_replace("\r\n", '', $result);
				$result = str_replace('\"', '"', $result);

				if ($result) {
					if ($this->setting->get('shipping_usps', 'shipping_usps_debug')) {
						log_message('debug', "USPS DATA SENT: " . urldecode($request));
						log_message('debug', "USPS DATA RECV: " . $result);
					}

					$dom = new \DOMDocument('1.0', 'UTF-8');
					$dom->loadXml($result);

					$rate_response = $dom->getElementsByTagName('RateV4Response')->item(0);
					$intl_rate_response = $dom->getElementsByTagName('IntlRateV2Response')->item(0);
					$error = $dom->getElementsByTagName('Error')->item(0);

					$firstclasses = array (
						'First-Class Mail Parcel',
						'First-Class Mail Large Envelope',
						'First-Class Mail Stamped Letter',
						'First-Class Mail Postcards'
					);

					if ($rate_response || $intl_rate_response) {
						if ($row_country_destination->iso_code_2 == 'US') {
							$allowed = array(0, 1, 2, 3, 4, 5, 6, 7, 12, 13, 16, 17, 18, 19, 22, 23, 25, 27, 28);

							$package = $rate_response->getElementsByTagName('Package')->item(0);

							$postages = $package->getElementsByTagName('Postage');

							if ($postages->length) {
								foreach ($postages as $postage) {
									$classid = $postage->getAttribute('CLASSID');

									if (in_array($classid, $allowed)) {
										if ($classid == '0') {
											$mailservice = $postage->getElementsByTagName('MailService')->item(0)->nodeValue;

											foreach ($firstclasses as $k => $firstclass)  {
												if ($firstclass == $mailservice) {
													$classid = $classid . $k;
													break;
												}
											}

											if (($this->setting->get('shipping_usps', 'shipping_usps_domestic_' . $classid))) {
												$cost = $postage->getElementsByTagName('Rate')->item(0)->nodeValue;

												$quote_data[$classid] = array(
													'code'         => 'usps.' . $classid,
													'title'        => $postage->getElementsByTagName('MailService')->item(0)->nodeValue,
													'cost'         => $this->currency->convert($cost, 'USD', $this->currency->getFrontEndCode()),
													'tax_class_id' => 0,
													'text'         => $this->currency->format($this->currency->convert($cost, 'USD', $this->currency->getFrontEndCode()), $this->currency->getFrontEndCode(), 1.0000000)
												);
											}

										} elseif ($this->setting->get('shipping_usps', 'shipping_usps_domestic_' . $classid)) {
											$cost = $postage->getElementsByTagName('Rate')->item(0)->nodeValue;

											$quote_data[$classid] = array(
												'code'         => 'usps.' . $classid,
												'title'        => $postage->getElementsByTagName('MailService')->item(0)->nodeValue,
												'cost'         => $this->currency->convert($cost, 'USD', $this->currency->getFrontEndCode()),
												'tax_class_id' => 0,
												'text'         => $this->currency->format($this->currency->convert($cost, 'USD', $this->currency->getFrontEndCode()), $this->currency->getFrontEndCode(), 1.0000000)
											);
										}
									}
								}
							} else {
								$error = $package->getElementsByTagName('Error')->item(0);

								$method_data = array(
									'code'       => 'usps',
									'title'      => lang('Text.text_usps_title', array(), $this->language->getFrontEndLocale()),
									'quote'      => $quote_data,
									'sort_order' => $this->setting->get('shipping_usps', 'shipping_usps_sort_order'),
									'error'      => $error->getElementsByTagName('Description')->item(0)->nodeValue
								);
							}
						} else {
							$allowed = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 21);

							$package = $intl_rate_response->getElementsByTagName('Package')->item(0);

							$services = $package->getElementsByTagName('Service');

							foreach ($services as $service) {
								$id = $service->getAttribute('ID');

								if (in_array($id, $allowed) && $this->setting->get('shipping_usps', 'shipping_usps_international_' . $id)) {
									$title = $service->getElementsByTagName('SvcDescription')->item(0)->nodeValue;

									if ($this->setting->get('shipping_usps', 'shipping_usps_display_time')) {
										$title .= ' (' . lang('Text.text_eta', array(), $this->language->getFrontEndLocale()) . ' ' . $service->getElementsByTagName('SvcCommitments')->item(0)->nodeValue . ')';
									}

									$cost = $service->getElementsByTagName('Postage')->item(0)->nodeValue;

									$quote_data[$id] = array(
										'code'         => 'usps.' . $id,
										'title'        => $title,
										'cost'         => $this->currency->convert($cost, 'USD', $this->currency->getFrontEndCode()),
										'tax_class_id' => 0,
										'text'         => $this->currency->format($this->currency->convert($cost, 'USD', $this->session->data['currency']), $this->session->data['currency'], 1.0000000)
									);
								}
							}
						}
					} elseif ($error) {
						$method_data = array(
							'code'       => 'usps',
							'title'      => lang('Text.text_usps_title', array(), $this->language->getFrontEndLocale()),
							'quote'      => $quote_data,
							'sort_order' => $this->setting->get('shipping_usps', 'shipping_usps_sort_order'),
							'error'      => $error->getElementsByTagName('Description')->item(0)->nodeValue
						);
					}
				}
			}

			if ($quote_data) {
				$title = lang('Text.text_usps_title', array(), $this->language->getFrontEndLocale());

				if ($this->setting->get('shipping_usps', 'shipping_usps_display_weight')) {
					$title .= ' (' . lang('Text.text_weight', array(), $this->language->getFrontEndLocale()) . ' ' . $this->weight->format($this->cart->getWeight($store_id, 'frontend'), $this->setting->get('setting', 'setting_frontend_weight_class_id'), lang('Common.common_decimal_point', array(), $this->language->getFrontEndLocale()), lang('Common.common_thousand_point', array(), $this->language->getFrontEndLocale())) . ')';
				}

				$method_data = array(
					'code'       => 'usps',
					'title'      => $title,
					'quote'      => $quote_data,
					'sort_order' => $this->setting->get('shipping_usps', 'shipping_usps_sort_order'),
					'error'      => false
				);
			}
		}

		return $method_data;
	}
}