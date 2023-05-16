# Translator

This application allows you to translate text in five languages (English, German, Spanish, Finnish and Russian). For some of the languages allowed, you can also choose how you want to translate (formal or more informal).

## Technologies Used

- PHP 8.2
- Symfony 6.2
- Bootstrap 5.3


## How to run a project

### Requirements
- You need to have PHP and Composer installed.

### Steps to follow

- Sign up at [www.deepl.com](https://www.deepl.com) and get an authentication key for the DeepL API.

- Clone the repository and open the folder.

```
git clone https://github.com/kapshtak/translator.git
cd translator
```
- Create an .env file and add the Deepl API key, the APP_ENV and APP_SECRET variables to it (you can use the .env.example file as a base, where you only need to change the API_AUTHORISATION variable).
```
###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=fsfsf35345qsfsfsf352452sfsdfsf22
###< symfony/framework-bundle ###
API_AUTHORIZATION=sfsfsfSFSFsdfs5w5sfsfsfsfsf
```
- Install the dependencies.
```
composer install
```
- Run the server.
```
symfony serve -d
```
- Open [http://127.0.0.1:8000/](http://127.0.0.1:8000/) in your browser.

## Credits

- [DeepL API](https://www.deepl.com/translator)

## Screenshots

![desktop](https://github.com/Kapshtak/translator/blob/main/screenshots/desktop.png)

## Author

- LinkedIn - [Arseniiy Kapshtyk](https://www.linkedin.com/in/kapshtyk/)
- Github - [@kapshtak](https://github.com/Kapshtak)

