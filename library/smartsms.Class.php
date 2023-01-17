<?php
namespace Smart;

class smartsmsClass
{
    public function __construct()
    {
        $this->gclient = new \GuzzleHttp\Client();
    }

    public function sendSms($to, $content)
    {

        $from = "SmartpayGH";

        $baseurl = 'http://smartsmsgh.com/api/send';

        $params = '?tokenUsername=hcahssyr';

        $params .= '&tokenPassword=1ccspasp';

        $params .= '&to=' . urlencode($to);

        $params .= '&from=' . urlencode($from);

        $params .= '&content=' . urlencode($content);

        $response = $this->sendCurl($baseurl, $params);

        return $this->formatResponse($response);

    }

    public function formatResponse($response)
    {
        return json_decode($response, true);
    }

    private function sendCurl($baseurl, $params)
    {

        $response = $this->gclient->request(
            'GET',
            $baseurl . $params,
            [
                // 'debug' => true,
                'verify' => false,
            ]
        );

        return $response->getBody();
    }

    public function validateNumber($number)
    {
        // Country codes
        $cnumber = '';
        $ccodes = $this->countries();
        // Clear all symbols
        $number = str_replace(' ', '', $number);
        $number = preg_replace('/[^\p{L}\p{N}\s]/u', '', $number);
        $number = preg_replace('/^00/', '', $number);
        foreach ($ccodes as $ccode) {
            $cnumber = '*';
            if (preg_match('/^' . $ccode . '/', $number) == true) {
                $cnumber = $ccode;
            }
        }
        if (is_numeric($number)) {
            if ($cnumber == 233 || $cnumber == '*') {
                $carriers = array('023', '024', '054', '055', '027', '057', '028', '028', '020', '050', '026', '056');
                if (strlen($number) >= 9) {
                    if (strlen($number) == 12) {
                        // Get the country code
                        $ccode = substr($number, 0, 3);
                        // Check country code
                        if (in_array($ccode, $ccodes)) {
                            return $number;
                        } else {
                            //return 'ERR: Invalid country code';
                            return false;
                        }
                    } else if (strlen($number) == 9) {
                        return $this->validateNumber('0' . substr($number, 0, 9));
                    } else if (strlen($number) == 10) {
                        $carrier = substr($number, 0, 3);
                        if (in_array($carrier, $carriers)) {
                            return '233' . substr($number, 1, 9);
                        } else {
                            // return 'ERR: Invalid carrier';
                            return false;
                        }
                    } else if (strlen($number) == 11) {
                        // return 'ERR: The length of the number is incorrect';
                        return false;
                    } else if (strlen($number) == 13) {
                        $ccode = substr($number, 0, 3);
                        if (in_array($ccode, $ccodes)) {
                            return $number;
                        } else {
                            // return 'ERR: Invalid country code';
                            return false;
                        }
                    }
                } else {
                    // return 'ERR: The length of the number is incorrect';
                    return false;
                }
                if (strlen($number) > 13) {
                    // return 'ERR: The length of the number is incorrect';
                    return false;
                }
            } else {
                return $number;
            }
        } else {
            // return 'ERR: The number is not numeric';
            return false;
        }
    } #end

    public function countries()
    {
        return array('93', '355', '213', '1684', '376', '244', '1264', '1268', '54', '374', '297', '61', '43', '994', '1242', '973', '880', '1246', '375', '32', '501', '229', '1441', '975', '591', '387', '267', '55', '673', '359', '226', '257', '855', '237', '1', '238', '1345', '236', '235', '56', '86', '61', '57', '269', '242', '243', '682', '506', '385', '53', '357', '420', '225', '45', '253', '1767', '593', '20', '503', '240', '291', '372', '251', '500', '298', '679', '358', '33', '594', '689', '262', '241', '220', '995', '49', '233', '350', '30', '299', '1473', '590', '1671', '502', '44', '224', '245', '592', '509', '504', '852', '36', '354', '91', '62', '98', '964', '353', '972', '39', '1876', '81', '44', '962', '7', '254', '686', '850', '82', '996', '856', '371', '961', '266', '231', '218', '423', '370', '352', '853', '389', '261', '265', '60', '960', '223', '356', '692', '596', '222', '230', '262', '52', '691', '373', '377', '976', '382', '1664', '212', '258', '95', '264', '674', '977', '31', '687', '64', '505', '227', '234', '683', '672', '1670', '47', '968', '92', '680', '970', '507', '675', '595', '51', '63', '870', '48', '351', '787', '974', '40', '7', '250', '262', '590', '685', '378', '239', '966', '221', '381', '248', '232', '65', '421', '386', '677', '252', '27', '34', '94', '290', '1869', '1758', '249', '597', '47', '268', '46', '41', '963', '886', '992', '255', '66', '670', '228', '690', '676', '1868', '216', '90', '993', '1649', '688', '265', '380', '971', '44', '1', '598', '998', '678', '58', '84', '681', '212', '967', '260', '263',
        );
    }

}
