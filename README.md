<h1 name="user-content-readme-top">AddressBook</h1>
<p align="center">
    <a href="https://github.com/aljawaid/AddressBook/releases">
        <img src="https://img.shields.io/github/v/release/aljawaid/AddressBook?style=for-the-badge&color=brightgreen" alt="GitHub Latest Release (by date)" title="GitHub Latest Release (by date)">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/releases">
        <img src="https://img.shields.io/github/downloads/aljawaid/AddressBook/total?style=for-the-badge&color=orange" alt="GitHub All Releases" title="GitHub All Downloads">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/releases">
        <img src="https://img.shields.io/github/directory-file-count/aljawaid/AddressBook?style=for-the-badge&color=orange" alt="GitHub Repository File Count" title="GitHub Repository File Count">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/releases">
        <img src="https://img.shields.io/github/repo-size/aljawaid/AddressBook?style=for-the-badge&color=orange" alt="GitHub Repository Size" title="GitHub Repository Size">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/releases">
        <img src="https://img.shields.io/github/languages/code-size/aljawaid/AddressBook?style=for-the-badge&color=orange" alt="GitHub Code Size" title="GitHub Code Size">
    </a>
</p>
<p align="center">
    <a href="https://github.com/aljawaid/AddressBook/discussions">
        <img src="https://img.shields.io/github/discussions/aljawaid/AddressBook?style=for-the-badge&color=blue" alt="GitHub Discussions" title="Read Discussions">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/compare">
        <img src="https://img.shields.io/github/commits-since/aljawaid/AddressBook/latest?include_prereleases&style=for-the-badge&color=blue" alt="GitHub Commits Since Last Release" title="GitHub Commits Since Last Release">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/compare">
        <img src="https://img.shields.io/github/commit-activity/m/aljawaid/AddressBook?style=for-the-badge&color=blue" alt="GitHub Commit Monthly Activity" title="GitHub Commit Monthly Activity">
    </a>
    <a href="https://github.com/kanboard/kanboard" title="Kanboard - Kanban Project Management Software">
        <img src="https://img.shields.io/badge/Plugin%20for-kanboard-D40000?style=for-the-badge&labelColor=000000" alt="Kanboard">
    </a>
</p>

Use the dedicated Address Book to create and manage contacts or organisations in projects and tasks. Add custom properties to standardise a deeper relationship between tasks and people or places. Contacts can be linked exclusively to tasks in a project. Users can sort their contact properties to show the first 3 properties (e.g. name, number and email) for quick reference from the task summary and the project board view.

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#screenshots">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Features

- Use the contact profile to create contacts per project or per task
- Easily link contacts to tasks
- Show linked contacts at a glance on each task summary
- Show linked contacts at a glance in the board view
- Works with MySQL, SQLite and PostgreSQL database types

**Contact Properties**
- Add contacts and organisations to tasks using property sets or create your own
- Add custom properties to the contact profile using one of the poperty types

**Property Types**
- HTML5 validated input types in a neat user-friendly form
- Types include:
  - Text - _for any freeform short text_
  - Address - _for physical addresses_
  - Email _for email addresses_
  - Long Text - _for longer text content such as notes_
  - Number - _for whole numbers_
  - Number (Decimal 2) - _for numbers containing 2 decimals_
  - Number (Decimal 4) - _for numbers containing 4 decimals_
  - Telephone - _for telephone, fax and mobile numbers_
  - URL - _for website, ftp, git, addresses_
- Add notes against each input field for users

**Property Sets**
- Add groups of properties to quickly build a contact profile ready for your contacts and projects
- Property Sets include:
  - Personal - _a general person_
  - Business - _a general business, organisation, or charity_
  - Company - _a large business with departments and extensions_
  - People - _names of people with contact numbers_
  - Team - _names of people with contact numbers and email addresses_
- Tip: Add all property sets and delete the ones you don't need

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#features">&#8592; Previous</a>] [<a href="#usage">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Screenshots

**Plugin Settings**  

![Plugin Settings](../master/Screenshots/screenshot-plugin-settings.png)

**Add Contact Form**  

![Add Contact Form](../master/Screenshots/screenshot-add-contact-form.png)

**Task Contacts**  

![Task Contacts](../master/Screenshots/screenshot-task-contacts.png)

**Linked Contacts**  

![Linked Contacts](../master/Screenshots/screenshot-linked-contacts.png)

**Contact Details**  

![Contact Details](../master/Screenshots/screenshot-contact-details.png)

**Project Contacts**  

![Project Contacts](../master/Screenshots/screenshot-project-contacts.png)

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#features">&#8592; Previous</a>] [<a href="#installation--compatibility">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Usage

Go to `Settings` &#10562; Address Book

_or_

Go to `Project Settings` &#10562; Address Book

_or_

Go to `Task` &#10562; Contacts

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#screenshots">&#8592; Previous</a>] [<a href="#authors--contributors">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Installation & Compatibility

<p align="left">
    <a href="https://github.com/aljawaid/AddressBook/actions/workflows/linter.yml">
        <img src="https://github.com/aljawaid/AddressBook/actions/workflows/linter.yml/badge.svg?branch=master&event=push" alt="Code Scanning" title="View Test">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/actions/workflows/php-compatibility-7.4.yaml">
        <img src="https://github.com/aljawaid/AddressBook/actions/workflows/php-compatibility-7.4.yaml/badge.svg?branch=master&event=push" alt="PHP Compatibility Test" title="View Test">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/actions/workflows/php-compatibility-8.0.yaml">
        <img src="https://github.com/aljawaid/AddressBook/actions/workflows/php-compatibility-8.0.yaml/badge.svg?branch=master&event=push" alt="PHP Compatibility Test" title="View Test">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/actions/workflows/php-compatibility-8.2.yaml">
        <img src="https://github.com/aljawaid/AddressBook/actions/workflows/php-compatibility-8.2.yaml/badge.svg?branch=master&event=push" alt="PHP Compatibility Test" title="View Test">
    </a>
</p>

<details>
    <summary><strong>Installation</strong></summary>

- Install via the **[Kanboard](https://github.com/kanboard/kanboard "Kanboard - Kanban Project Management Software") Plugin Directory** or see [INSTALL.md](../master/INSTALL.md)
- Read the full [**Changelog**](../master/changelog.md "See changes") to see the latest updates

</details>
<details>
    <summary><strong>Compatibility</strong></summary>

- Requires [Kanboard](https://github.com/kanboard/kanboard "Kanboard - Kanban Project Management Software") ≥`1.2.20`
- **Other Plugins & Action Plugins**
  - _No known issues_
  - Compatible with [KanboardCSS](https://github.com/aljawaid/KanboardCSS)
- **Core Files & Templates**
  - _No template overrides_
  - Database Changes:
    - `01` New database table created as `address_book_contacts_items`
    - `01` New database table created as `address_book_contacts_contact`
    - `01` New database table created as `address_book_contacts_task_has_contact`

</details>
<details>
    <summary><strong>Translations</strong></summary>

- _Starter template available_

</details>

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#usage">&#8592; Previous</a>] [<a href="#license">&#8594; Next</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## Authors & Contributors

- [@aljawaid](https://github.com/aljawaid) - Author
- [Martin Middeke](https://github.com/Busfreak/plugin-contacts) - Contributor (selected features from the Contacts plugin)
- _Contributors welcome_

<p align="right">[<a href="#user-content-readme-bottom">&#8595; Bottom</a>] [<a href="#installation--compatibility">&#8592; Previous</a>] [<a href="#user-content-readme-top">&#8593; Top</a>]</p>

## License

- This project is distributed under the [MIT License](../master/LICENSE "Read The MIT license")

---

<p align="center">
    <a href="https://github.com/aljawaid/AddressBook/stargazers" title="View Stargazers">
        <img src="https://img.shields.io/github/stars/aljawaid/AddressBook?logo=github&style=flat-square" alt="AddressBook">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/forks" title="See Forks">
        <img src="https://img.shields.io/github/forks/aljawaid/AddressBook?logo=github&style=flat-square" alt="AddressBook">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/blob/master/LICENSE" title="Read License">
        <img src="https://img.shields.io/github/license/aljawaid/AddressBook?style=flat-square" alt="AddressBook">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/issues" title="Open Issues">
        <img src="https://img.shields.io/github/issues-raw/aljawaid/AddressBook?style=flat-square" alt="AddressBook">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/issues?q=is%3Aissue+is%3Aclosed" title="Closed Issues">
        <img src="https://img.shields.io/github/issues-closed/aljawaid/AddressBook?style=flat-square" alt="AddressBook">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/discussions" title="Read Discussions">
        <img src="https://img.shields.io/github/discussions/aljawaid/AddressBook?style=flat-square" alt="AddressBook">
    </a>
    <a href="https://github.com/aljawaid/AddressBook/compare/" title="Latest Commits">
        <img alt="GitHub commits since latest release (by date)" src="https://img.shields.io/github/commits-since/aljawaid/AddressBook/latest?style=flat-square">
    </a>
</p>
<a name="user-content-readme-bottom"></a>
<p align="right">[<a href="#user-content-readme-top">&#8593; Top</a>]</p>
