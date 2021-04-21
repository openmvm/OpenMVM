<?php

namespace Modules\OpenMVM\ShippingMethod\Models;

class FedexModel extends \CodeIgniter\Model
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

		// Get state to geo zone
		$builder_state_to_geo_zone = $this->db->table('state_to_geo_zone');
		$builder_state_to_geo_zone->where('geo_zone_id', $this->setting->get('shipping_fedex', 'shipping_fedex_geo_zone_id'));
		$builder_state_to_geo_zone->where('country_id', $address->country_id);
		$builder_state_to_geo_zone->groupStart();
		$builder_state_to_geo_zone->where('state_id', $address->state_id);
		$builder_state_to_geo_zone->orWhere('state_id', 0);
		$builder_state_to_geo_zone->groupEnd();

		$total_results = $builder_state_to_geo_zone->countAllResults();

		if (empty($this->setting->get('shipping_fedex', 'shipping_fedex_geo_zone_id'))) {
			$status = true;
		} elseif ($total_results > 0) {
			$status = true;
		} else {
			$status = false;
		}

		if ($status) {
			// Weight
    	$weight = $this->weight->convert($this->cart->getWeight($store_id), $this->setting->get('setting', 'setting_frontend_weight_class_id'), $this->setting->get('shipping_fedex', 'shipping_fedex_weight_class_id'));

			$weight_code = strtoupper($this->weight->getUnit($this->setting->get('shipping_fedex', 'shipping_fedex_weight_class_id')));

			if ($weight_code == 'KGS') {
				$weight_code = 'KG';
			}

			if ($weight_code == 'LBS') {
				$weight_code = 'LB';
			}

			// Date
			$date = time();

			$day = date('l', $date);

			if ($day == 'Saturday') {
				$date += 172800;
			} elseif ($day == 'Sunday') {
				$date += 86400;
			}

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

			// FedEx Configurations
			if ($this->setting->get('shipping_fedex', 'shipping_fedex_mode') == 'production') {
				$url = $this->setting->get('shipping_fedex', 'shipping_fedex_url_production');
			} else {
				$url = $this->setting->get('shipping_fedex', 'shipping_fedex_url_test');
			}

			// The XML
			$xml  = '<?xml version="1.0"?>';
			$xml .= '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://fedex.com/ws/rate/v10">';
			$xml .= '	<SOAP-ENV:Body>';
			$xml .= '		<ns1:RateRequest>';
			$xml .= '			<ns1:WebAuthenticationDetail>';
			$xml .= '				<ns1:UserCredential>';
			$xml .= '					<ns1:Key>' . $this->setting->get('shipping_fedex', 'shipping_fedex_key') . '</ns1:Key>';
			$xml .= '					<ns1:Password>' . $this->setting->get('shipping_fedex', 'shipping_fedex_password') . '</ns1:Password>';
			$xml .= '				</ns1:UserCredential>';
			$xml .= '			</ns1:WebAuthenticationDetail>';
			$xml .= '			<ns1:ClientDetail>';
			$xml .= '				<ns1:AccountNumber>' . $this->setting->get('shipping_fedex', 'shipping_fedex_account_number') . '</ns1:AccountNumber>';
			$xml .= '				<ns1:MeterNumber>' . $this->setting->get('shipping_fedex', 'shipping_fedex_meter_number') . '</ns1:MeterNumber>';
			$xml .= '			</ns1:ClientDetail>';
			$xml .= '			<ns1:Version>';
			$xml .= '				<ns1:ServiceId>crs</ns1:ServiceId>';
			$xml .= '				<ns1:Major>10</ns1:Major>';
			$xml .= '				<ns1:Intermediate>0</ns1:Intermediate>';
			$xml .= '				<ns1:Minor>0</ns1:Minor>';
			$xml .= '			</ns1:Version>';
			$xml .= '			<ns1:ReturnTransitAndCommit>true</ns1:ReturnTransitAndCommit>';
			$xml .= '			<ns1:RequestedShipment>';
			$xml .= '				<ns1:ShipTimestamp>' . date('c', $date) . '</ns1:ShipTimestamp>';
			$xml .= '				<ns1:DropoffType>' . $this->setting->get('shipping_fedex', 'shipping_fedex_dropoff_type') . '</ns1:DropoffType>';
			$xml .= '				<ns1:PackagingType>' . $this->setting->get('shipping_fedex', 'shipping_fedex_packaging_type') . '</ns1:PackagingType>';
			
			$xml .= '				<ns1:Shipper>';
			$xml .= '					<ns1:Contact>';
			$xml .= '						<ns1:PersonName>' . $row_store_owner->firstname . ' ' . $row_store_owner->lastname . '</ns1:PersonName>';
			$xml .= '						<ns1:CompanyName>' . $row_store->name . '</ns1:CompanyName>';
			$xml .= '						<ns1:PhoneNumber>' . $row_store_owner->telephone . '</ns1:PhoneNumber>';
			$xml .= '					</ns1:Contact>';
			$xml .= '					<ns1:Address>';

			if (in_array($row_country_origin->iso_code_2, array('US', 'CA'))) {
				$xml .= '						<ns1:StateOrProvinceCode>' . ($row_state_origin ? $row_state_origin->code : '') . '</ns1:StateOrProvinceCode>';
			} else {
				$xml .= '						<ns1:StateOrProvinceCode></ns1:StateOrProvinceCode>';
			}

			$xml .= '						<ns1:PostalCode>' . $row_store->shipping_origin_postal_code . '</ns1:PostalCode>';
			$xml .= '						<ns1:CountryCode>' . $row_country_origin->iso_code_2 . '</ns1:CountryCode>';
			$xml .= '					</ns1:Address>';
			$xml .= '				</ns1:Shipper>';

			$xml .= '				<ns1:Recipient>';
			$xml .= '					<ns1:Contact>';
			$xml .= '						<ns1:PersonName>' . $address->firstname . ' ' . $address->lastname . '</ns1:PersonName>';
			$xml .= '						<ns1:CompanyName>' . $address->company . '</ns1:CompanyName>';
			$xml .= '						<ns1:PhoneNumber>' . $address->telephone . '</ns1:PhoneNumber>';
			$xml .= '					</ns1:Contact>';
			$xml .= '					<ns1:Address>';
			$xml .= '						<ns1:StreetLines>' . $address->address_1 . '</ns1:StreetLines>';
			$xml .= '						<ns1:City>' . $address->city . '</ns1:City>';

			if (in_array($row_country_destination->iso_code_2, array('US', 'CA'))) {
				$xml .= '						<ns1:StateOrProvinceCode>' . ($row_state_destination ? $row_state_destination->code : '') . '</ns1:StateOrProvinceCode>';
			} else {
				$xml .= '						<ns1:StateOrProvinceCode></ns1:StateOrProvinceCode>';
			}

			$xml .= '						<ns1:PostalCode>' . $address->postal_code . '</ns1:PostalCode>';
			$xml .= '						<ns1:CountryCode>' . $row_country_destination->iso_code_2 . '</ns1:CountryCode>';
			$xml .= '						<ns1:Residential>' . ($address->company ? 'true' : 'false') . '</ns1:Residential>';
			$xml .= '					</ns1:Address>';
			$xml .= '				</ns1:Recipient>';
			$xml .= '				<ns1:ShippingChargesPayment>';
			$xml .= '					<ns1:PaymentType>SENDER</ns1:PaymentType>';
			$xml .= '					<ns1:Payor>';
			$xml .= '						<ns1:AccountNumber>' . $this->setting->get('shipping_fedex', 'shipping_fedex_account_number') . '</ns1:AccountNumber>';
			$xml .= '						<ns1:CountryCode>' . $row_country_origin->iso_code_2 . '</ns1:CountryCode>';
			$xml .= '					</ns1:Payor>';
			$xml .= '				</ns1:ShippingChargesPayment>';
			$xml .= '				<ns1:RateRequestTypes>' . $this->setting->get('shipping_fedex', 'shipping_fedex_rate_type') . '</ns1:RateRequestTypes>';
			$xml .= '				<ns1:PackageCount>1</ns1:PackageCount>';
			$xml .= '				<ns1:RequestedPackageLineItems>';
			$xml .= '					<ns1:SequenceNumber>1</ns1:SequenceNumber>';
			$xml .= '					<ns1:GroupPackageCount>1</ns1:GroupPackageCount>';
			$xml .= '					<ns1:Weight>';
			$xml .= '						<ns1:Units>' . $weight_code . '</ns1:Units>';
			$xml .= '						<ns1:Value>' . $weight . '</ns1:Value>';
			$xml .= '					</ns1:Weight>';
			$xml .= '					<ns1:Dimensions>';
			$xml .= '						<ns1:Length>20</ns1:Length>';
			$xml .= '						<ns1:Width>20</ns1:Width>';
			$xml .= '						<ns1:Height>20</ns1:Height>';
			$xml .= '						<ns1:Units>CM</ns1:Units>';
			$xml .= '					</ns1:Dimensions>';
			$xml .= '				</ns1:RequestedPackageLineItems>';
			$xml .= '			</ns1:RequestedShipment>';
			$xml .= '		</ns1:RateRequest>';
			$xml .= '	</SOAP-ENV:Body>';
			$xml .= '</SOAP-ENV:Envelope>';

			$curl = curl_init($url);

			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);

			curl_close($curl);

			$dom = new \DOMDocument('1.0', 'UTF-8');
			$dom->loadXml($response);

			if ($dom->getElementsByTagName('faultcode')->length > 0) {
  			$error = $dom->getElementsByTagName('cause')->item(0)->nodeValue;

  			//$this->log->write('FEDEX :: ' . $response);
			} elseif ($dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'FAILURE' || $dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'ERROR') {
				$error = $dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue;

				//$this->log->write('FEDEX :: ' . $response);
			} else {
				$rate_reply_details = $dom->getElementsByTagName('RateReplyDetails');

				foreach ($rate_reply_details as $rate_reply_detail) {
					$code = strtolower($rate_reply_detail->getElementsByTagName('ServiceType')->item(0)->nodeValue);

					if (!empty($this->setting->get('shipping_fedex', 'shipping_fedex_service')) && is_array($this->setting->get('shipping_fedex', 'shipping_fedex_service')) && in_array(strtoupper($code), $this->setting->get('shipping_fedex', 'shipping_fedex_service'))) {
						$title = lang('Text.text_' . $code, array(), $this->language->getFrontEndLocale());

						$delivery_time_stamp = $rate_reply_detail->getElementsByTagName('DeliveryTimestamp');

						if ($this->setting->get('shipping_fedex', 'shipping_fedex_display_time') && $delivery_time_stamp->length) {
							$title .= ' (' . lang('Text.text_eta', array(), $this->language->getFrontEndLocale()) . ' ' . date(lang('Common.common_date_format_short', array(), $this->language->getFrontEndLocale()) . ' ' . lang('Common.common_time_format', array(), $this->language->getFrontEndLocale()), strtotime($delivery_time_stamp->item(0)->nodeValue)) . ')';
						}

						$rated_shipment_details = $rate_reply_detail->getElementsByTagName('RatedShipmentDetails');

						foreach ($rated_shipment_details as $rated_shipment_detail) {
							$shipment_rate_detail = $rated_shipment_detail->getElementsByTagName('ShipmentRateDetail')->item(0);
							$shipment_rate_detail_type = explode('_', $shipment_rate_detail->getElementsByTagName('RateType')->item(0)->nodeValue);

							if (count($shipment_rate_detail_type) == 3 && $shipment_rate_detail_type[1] == $this->setting->get('shipping_fedex', 'shipping_fedex_rate_type')) {
								$total_net_charge = $shipment_rate_detail->getElementsByTagName('TotalNetCharge')->item(0);

								break;
							}
						}

						$cost = $total_net_charge->getElementsByTagName('Amount')->item(0)->nodeValue;

						$currency = $total_net_charge->getElementsByTagName('Currency')->item(0)->nodeValue;

						$quote_data[$code] = array(
							'code'         => 'fedex.' . $code,
							'title'        => $title,
							'cost'         => $this->currency->convert($cost, $currency, $this->currency->getFrontEndCode()),
							'tax_class_id' => 0,
							'text'         => $this->currency->format($this->currency->convert($cost, $currency, $this->currency->getFrontEndCode()), $this->currency->getFrontEndCode(), 1.0000000)
						);
					}
				}
			}
		}

		$method_data = array();

		if ($quote_data || $error) {
			$title = lang('Text.text_fedex_title', array(), $this->language->getFrontEndLocale());

			if ($this->setting->get('shipping_fedex', 'shipping_fedex_display_weight')) {
				$title .= ' (' . lang('Text.text_weight', array(), $this->language->getFrontEndLocale()) . ' ' . $this->weight->format($weight, $this->setting->get('shipping_fedex', 'shipping_fedex_weight_class_id')) . ')';
			}

			$method_data = array(
				'code'       => 'fedex',
				'title'      => $title,
				'quote'      => $quote_data,
				'sort_order' => $this->setting->get('shipping_fedex', 'shipping_fedex_sort_order'),
				'error'      => $error
			);
		}

		return $method_data;
	}
}