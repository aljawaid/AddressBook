<?php

/**
 * Verifies AddressBook theme-aware contrast and embedded icon colors.
 *
 * Related source files: Assets/css/address-book.css and
 * Assets/css/address-book-icons.css.
 */

declare(strict_types=1);

$stylesheet = file_get_contents(__DIR__ . '/../Assets/css/address-book.css');
$iconStylesheet = file_get_contents(__DIR__ . '/../Assets/css/address-book-icons.css');

addressBookAssertTrue($stylesheet !== false, 'The AddressBook stylesheet could not be read.');
addressBookAssertTrue($iconStylesheet !== false, 'The AddressBook icon stylesheet could not be read.');

addressBookAssertContains(
    '--ab-blue: light-dark(#20369F, #8FA3FF);',
    $stylesheet,
    'AddressBook accents must follow Kanboard\'s active color scheme.'
);
addressBookAssertContains(
    '--ab-button: light-dark(rgb(32, 54, 159, .8), #314BC2);',
    $stylesheet,
    'AddressBook button surfaces must retain readable white text in dark mode.'
);
addressBookAssertContains(
    '--ab-text: light-dark(#000000, #E6EDF3);',
    $stylesheet,
    'AddressBook form text must remain readable in dark mode.'
);
addressBookAssertContains(
    "fill='%2320369F' style='fill:light-dark(%2320369F,%238FA3FF)'",
    $iconStylesheet,
    'Blue embedded SVG fills must provide a dark-theme color.'
);
addressBookAssertContains(
    "fill='%23000000' style='fill:light-dark(%23000000,%23E6EDF3)'",
    $iconStylesheet,
    'Black embedded SVG fills must provide a dark-theme color.'
);
addressBookAssertContains(
    '--ab-icon-image: url(',
    $iconStylesheet,
    'Embedded SVGs must remain available as reusable icon masks.'
);
addressBookAssertContains(
    'mask-image: var(--ab-icon-image);',
    $iconStylesheet,
    'Icons on transparent surfaces must use the theme-aware accent color.'
);

$blueFallbackCount = substr_count($iconStylesheet, "fill='%2320369F'");
$blueThemeCount = substr_count($iconStylesheet, "style='fill:light-dark(%2320369F,%238FA3FF)'");
$blackFallbackCount = substr_count($iconStylesheet, "fill='%23000000'");
$blackThemeCount = substr_count($iconStylesheet, "style='fill:light-dark(%23000000,%23E6EDF3)'");

addressBookAssertTrue(
    $blueFallbackCount === $blueThemeCount,
    'Every blue embedded SVG fill must retain a fallback and provide a dark-theme color.'
);
addressBookAssertTrue(
    $blackFallbackCount === $blackThemeCount,
    'Every black embedded SVG fill must retain a fallback and provide a dark-theme color.'
);
addressBookAssertTrue(
    addressBookContrastRatio('#8FA3FF', '#222222') >= 4.5,
    'Dark-theme accent text must meet WCAG AA contrast against Kanboard\'s dark canvas.'
);
addressBookAssertTrue(
    addressBookContrastRatio('#FFFFFF', '#314BC2') >= 4.5,
    'Dark-theme buttons must meet WCAG AA contrast for white text.'
);

function addressBookAssertContains(string $needle, string $haystack, string $message): void
{
    addressBookAssertTrue(strpos($haystack, $needle) !== false, $message);
}

function addressBookAssertTrue(bool $condition, string $message): void
{
    if (! $condition) {
        throw new RuntimeException($message);
    }
}

function addressBookContrastRatio(string $foreground, string $background): float
{
    $foregroundLuminance = addressBookRelativeLuminance($foreground);
    $backgroundLuminance = addressBookRelativeLuminance($background);
    $lighter = max($foregroundLuminance, $backgroundLuminance);
    $darker = min($foregroundLuminance, $backgroundLuminance);

    return ($lighter + 0.05) / ($darker + 0.05);
}

function addressBookRelativeLuminance(string $hexColor): float
{
    $red = hexdec(substr($hexColor, 1, 2)) / 255;
    $green = hexdec(substr($hexColor, 3, 2)) / 255;
    $blue = hexdec(substr($hexColor, 5, 2)) / 255;
    $channels = array($red, $green, $blue);

    foreach ($channels as &$channel) {
        $channel = $channel <= 0.04045
            ? $channel / 12.92
            : (($channel + 0.055) / 1.055) ** 2.4;
    }
    unset($channel);

    return (0.2126 * $channels[0]) + (0.7152 * $channels[1]) + (0.0722 * $channels[2]);
}
