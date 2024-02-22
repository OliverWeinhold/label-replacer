# Label Replacer WordPress Plugin

The Label Replacer is a simple WordPress plugin designed to automatically replace specific text labels on your website. With an easy-to-use syntax, you can define labels and have them replaced within your website's text with your desired text. This plugin is perfect for changing terms or phrases across your pages without having to edit each page individually.

## Features
- Define unique labels easily with a simple syntax.
- Automatically replace labels within your text.
- Define labels anywhere on the page
- Also works with embedded content and plugins (e.g. Insert Pages Plugin)
- Allow usage of WP HTML elements within labels (e.g. Links)

## Installation

1. Download the plugin files from this repository.
2. Navigate to your WordPress admin, go to `Plugins -> Add New -> Upload Plugin`.
3. Choose the plugin file you downloaded and click `Install Now`.
4. After installation, click `Activate` to activate the plugin.

## Usage

1. Define a label anywhere in your post or page content using the following syntax:
   ```plaintext
   {{label:YourLabel=YourReplacementText}}
   ```
   Example:
   ```plaintext
   {{label:DeviceVersion=v1.0}}
   ```  
2. Now, wherever you want to replace the label with the text, use the following syntax:
   ```plaintext
   {{label:DeviceVersion}}
   ```  
   Example:
   ```plaintext
   This Guide is for Device Version {{label:DeviceVersion}}.
   ```   
3. The plugin will automatically replace the label with the defined text:
   ```plaintext
   This Guide is for Device Version v1.0.
   ``` 
 
## Configuration
The settings page can be found under the WordPress settings.

**Allow HTML:** Allows the use of HTML elements such as links within the labels. 
> [!WARNING]
> This setting should only be used if the admins and authors are aware of the risks when using HTML elements!

## License

This project is licensed under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.html).

## Author

- [Oliver Weinhold](https://oliverweinhold.de/)

## Support

Please note that the maintenance of this plugin is not continuous and not guaranteed. For support, feature requests, or bug reporting, please use GitHub.


## Contributions

Contributions are welcome! Feel free to open a pull request or issue on GitHub!