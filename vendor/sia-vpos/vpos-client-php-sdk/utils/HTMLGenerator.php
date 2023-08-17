<?php


/**
 * Class HTMLGenerator
 *
 * Utility class implementing methods to generate customs HTML pages
 *
 * @author Gabriel Raul Marini
 */
class HTMLGenerator
{

    private const FORM_PATTERN = "PGZvcm0gYWN0aW9uPSJbQVBPU19VUkxdIiBtZXRob2Q9IlBPU1QiPjxpbnB1dCBuYW1lPSJQQUdFIiB0eXBlPSJoaWRkZW4iIHZhbHVlPSJMQU5EIj5bUEFSQU1FVEVSU108aW5wdXQgaWQ9InN1Ym1pdCIgc3R5bGU9ImRpc3BsYXk6IG5vbmU7IiB0eXBlPXN1Ym1pdCAgdmFsdWU9Ii4iPjwvZm9ybT4=";
    private const INPUT_PATTERN = "PGlucHV0IHR5cGU9ImhpZGRlbiIgbmFtZT0iS0VZIiB2YWx1ZT0iVkFMVUUiPg==";
    private const SCRIPT = "PHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPndpbmRvdy5vbmxvYWQgPSBmdW5jdGlvbigpe3NldFRpbWVvdXQoZnVuY3Rpb24oKXtkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnc3VibWl0JykuY2xpY2soKTt9LCBbREVMQVldKTt9PC9zY3JpcHQ+";
    private const DEFAULT_HTML = '<div><form id="myForm" action="[VPOS_URL]" method="POST"><input name="PAGE" type="hidden" value="LAND">[PARAMETERS]</form><script type="text/javascript">function subForm() {document.getElementById(\'myForm\').submit();}</script></div>';
    private const TOKEN_HTML = '<div><form id="myForm"action="[VPOS_URL]" method="POST"><input name="PAGE" type="hidden" value="TOKEN">[PARAMETERS]</form><script type="text/javascript">function subForm() {document.getElementById(\'myForm\').submit();}</script></div>';

    /**
     * Generates the hidden form content for a redirect payment
     *
     * @param array $params to be filled in the hidden form
     * @return string the concatenated string with the qualified <input ..> HTML tags
     */
    public function generateParamsHtml(array $params)
    {
        $paramString = "";
        $decodedInputPattern = base64_decode(static::INPUT_PATTERN);

        foreach ($params as $key => $value)
            if (isset($params[$key]) && strlen($value) > 0) {
                $paramString .= str_replace("KEY", $key, $decodedInputPattern);
                $paramString = str_replace("VALUE", $value, $paramString);
            }

        return $paramString;
    }

    /**
     * @param string $base64 encoded html document
     * @param int $delay milliseconds to wait before redirecting to sia VPOS page
     * @return string the input template customized with the payment initiation data
     */
    public function base64ToHtml(string $base64, int $delay)
    {
        $html = base64_decode($base64);
        $form = base64_decode(static::FORM_PATTERN);
        $script = base64_decode(static::SCRIPT);

        $html = str_replace("</body>", $form . "</body>", $html);
        $html = str_replace("</html>", $script . "</html>", $html);
        $html = str_replace("[DELAY]", $delay, $html);

        return $html;
    }

    /**
     * @param string $urlApos redirect url used to carry out the payment
     * @param array $params payment info
     * @param bool $isToken token payment instrument check
     * @return string the html document
     */
    public function htmlOutput(string $urlApos, array $params, bool $isToken)
    {
        $html = self::DEFAULT_HTML;
        if($isToken)
        {
            $html = self::TOKEN_HTML;
        }
        $html = str_replace("[VPOS_URL]", $urlApos, $html);
        $html = str_replace("[PARAMETERS]", $this->generateParamsHtml($params), $html);
        return $html;
    }

}
