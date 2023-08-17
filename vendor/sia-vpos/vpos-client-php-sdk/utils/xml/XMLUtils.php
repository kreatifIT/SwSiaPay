<?php

/**
 * Class XMLUtils
 *
 * Utility class used to build generic XML documents
 *
 * @author Gabriel Raul Marini
 */
class XMLUtils
{
    private const OPEN_TAG = "<";
    private const CLOSE_TAG = ">";
    private const CLOSE_SLASH = "/";

    private static function getOpenTag(string $name): string
    {
        return self::OPEN_TAG . $name . self::CLOSE_TAG;
    }

    private static function getCloseTag(string $name)
    {
        return self::OPEN_TAG . self::CLOSE_SLASH . $name . self::CLOSE_TAG;
    }

    private static function getEmptyTag(string $name)
    {
        return self::OPEN_TAG . $name . self::CLOSE_SLASH . self::CLOSE_TAG;
    }

    /**
     * Append an open tag to the passed xml string
     *
     * @param string $xml target string
     * @param string $tagName name of the requested tag
     */
    public static function appendOpenTag(string &$xml, string $tagName): void
    {
        $xml .= static::getOpenTag($tagName);
    }

    /**
     * Append a closing tag to the passed xml string
     *
     * @param string $xml target string
     * @param string $tagName name of the requested closing tag
     */
    public static function appendCloseTag(string &$xml, string $tagName): void
    {
        $xml .= static::getCloseTag($tagName);
    }

    /**
     * Append a tag with the specified content to the input xml string
     *
     * @param string $xml target string
     * @param string $tagName name of the requested tag
     * @param string|null $content of the tag
     */
    public static function appendTag(string &$xml, string $tagName, ?string $content): void
    {
        if (isset($content))
            if (strlen($content) > 0)
                $xml .= self::getOpenTag($tagName) . $content . self::getCloseTag($tagName);
            else
                $xml .= self::getEmptyTag($tagName);
    }
}