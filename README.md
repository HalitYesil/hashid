# HashID

HashID is a lightweight PHP class for encoding and decoding integers to and from short, URL-safe alphanumeric strings using a Base36 character set (`0-9`, `a-z`). It is designed to be fast, thread-safe, and case-insensitive (optional), making it ideal for generating compact identifiers for URLs, database keys, or other applications where short, readable strings are needed.

## Features
- **Fast and Efficient**: Uses a lookup table for quick encoding and decoding.
- **Case-Insensitive Decoding**: Optionally ignores case for decoding (e.g., `kf12oi` and `KF12OI` are treated the same).
- **Ignores Non-Base36 Characters**: Strips invalid characters during decoding for robust handling.
- **Thread-Safe**: Static methods ensure safe usage in multi-threaded environments.
- **No External Dependencies**: Pure PHP implementation, easy to integrate.
- **MIT License**: Freely usable and modifiable.

## Installation

### Using Composer
1. Add the package to your project:
   ```bash
   composer require halityesil/hashid
   ```
2. Include the class in your PHP code:
   ```php
   require 'vendor/autoload.php';
   use HashID;
   ```

### Manual Installation
1. Download `HashID.php` from the [GitHub repository](https://github.com/halityesil/hashid).
2. Include it in your project:
   ```php
   require_once 'path/to/HashID.php';
   ```

## Usage

### Encoding an Integer
Convert a number to a Base36 string:
```php
$hash = HashID::encode(1234567890);
echo $hash; // Outputs: "kf12oi"
```

### Decoding a Hash
Convert a Base36 string back to the original number:
```php
$number = HashID::decode('kf12oi');
echo $number; // Outputs: 1234567890
```

### Case-Insensitive Decoding
By default, decoding is case-insensitive. You can explicitly control this behavior:
```php
$number = HashID::decode('KF12OI', true); // Case-insensitive
echo $number; // Outputs: 1234567890

$number = HashID::decode('KF12OI', false); // Case-sensitive, throws exception if invalid
```

### Handling Invalid Input
- Negative numbers in `encode` throw an `InvalidArgumentException`.
- Non-Base36 characters in `decode` are ignored.
- Empty strings in `decode` return `0`.

## Example
```php
try {
    $hash = HashID::encode(4522);
    echo $hash; // Outputs: "c6"

    $number = HashID::decode('c6');
    echo $number; // Outputs: 4522

    $number = HashID::decode('C6', true); // Case-insensitive
    echo $number; // Outputs: 4522

    $number = HashID::decode('c6!@#', true); // Ignores invalid characters
    echo $number; // Outputs: 4522
} catch (\InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Why Use HashID?
- **Compact URLs**: Generate short, readable identifiers for URLs (e.g., `/product/c6` instead of `/product/4522`).
- **Performance**: Lookup table ensures fast encoding/decoding.
- **Robustness**: Handles edge cases like empty strings, invalid characters, and case sensitivity.
- **No Dependencies**: Lightweight and easy to integrate into any PHP project.

## API Reference

### `HashID::encode(int $number): string`
- **Description**: Encodes an integer into a Base36 string.
- **Parameters**:
  - `$number`: The integer to encode (must be non-negative).
- **Returns**: The Base36-encoded string.
- **Throws**: `\InvalidArgumentException` if the input is negative.

### `HashID::decode(string $hash, bool $insensitive = true): int`
- **Description**: Decodes a Base36 string back to the original integer.
- **Parameters**:
  - `$hash`: The Base36 string to decode.
  - `$insensitive`: If `true`, decoding is case-insensitive (default: `true`).
- **Returns**: The decoded integer.
- **Throws**: `\InvalidArgumentException` if case-sensitive decoding encounters invalid characters.

## Performance
- **Encoding**: O(log n) where n is the input number.
- **Decoding**: O(m) where m is the length of the input string.
- Optimized with a lookup table for fast character-to-index mapping.

## Security
- Uses a simple Base36 alphabet (`0-9`, `a-z`), making it predictable but safe for most use cases.
- For applications requiring obfuscation, consider adding a salt (not implemented in this version but can be extended).
- Does not expose sensitive data, as it only converts integers to strings.

## Contributing
Contributions are welcome! Please submit issues or pull requests to the [GitHub repository](https://github.com/halityesil/hashid).

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m 'Add your feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a pull request.

## License
This project is licensed under the [MIT License](LICENSE).

## Author
- **Halit Yeşil** ([@halityesil](https://github.com/halityesil))

## Version
- **1.0.0** (Released: 2025-07-10)