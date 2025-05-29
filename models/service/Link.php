<?php

namespace app\models\service;

use Yii;
use app\models\Link as BaseLink;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

/**
 * This model processes operations for url.
 */
class Link extends BaseLink
{

    const QR_SIZE = 300;
    const QR_MARGIN = 10;

    const SHORT_CODE_CHARS = 'abcdefghijkmnpqrstuvwxyz-ABCDEFGHJKLMNPQRSTUVWXYZ_23456789';

    const HTTP_CODES_FROM = 200;
    const HTTP_CODES_TO = 400;
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';


    /**
     * Generates QR-code
     * @return string
     */
    public function getQr()
    {
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $this->shortUrl,
            size: self::QR_SIZE,
            margin: self::QR_MARGIN,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        );

        $result = $builder->build();

        return $result->getDataUri();
    }

        
    /**
     * Generates a unique short code
     * @return string
     */
    public static function generateShortCode()
    {
        $code = '';
        for ($i = 0; $i < parent::SHORT_CODE_LENGTH; $i++) {
            $code .= self::SHORT_CODE_CHARS[random_int(0, strlen(self::SHORT_CODE_CHARS) - 1)];
        }
        if (self::find()->where(['short_code' => $code])->exists()) {
            return self::generateShortCode();
        }
        return $code;
    }


    /**
     * Generates short URL
     * @return string
     */
    public function getShortUrl()
    {
        return Yii::$app->urlManager->createAbsoluteUrl([$this->short_code]);
    }


    /**
     * Checks if the original url is available
     * @return bool
     */
    public function isAccessible()
    {
        $contextOptions = [
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: ' . self::USER_AGENT . "\r\n",
                'follow_location' => 1,
                'timeout' => 5,
            ]
        ];

        $context = stream_context_create($contextOptions);

        try {
            $headers = @get_headers($this->original_url, 1, $context);

            if ($headers === false || !is_array($headers)) {
                return false;
            }

            $statusLine = is_array($headers) ? $headers[0] : null;

            if (!$statusLine || !preg_match('/HTTP\/\d\.\d\s+(\d+)/', $statusLine, $matches)) {
                return false;
            }

            $httpCode = (int)$matches[1];

            return $httpCode >= self::HTTP_CODES_FROM && $httpCode < self::HTTP_CODES_TO;

        } catch (\Exception $e) {
            return false;
        }
    }

}