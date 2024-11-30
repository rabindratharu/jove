# Jove — A WordPress Block Theme

![Image](https://user-images.githubusercontent.com/1415737/217930880-5d019715-f0c2-4f2f-9d24-dd466abf531b.jpg)

Jove is a modern WordPress block theme by [The JoVE Team](https://www.jove.com). Jove is built to work seamlessly with the WordPress block editor and site editor, where you can create beautiful, fully-customizable websites with WordPress's built-in page builder — no page builder or coding skills required.

Jove ships with over 50 beautifully-designed patterns, page templates, block styles, and style variations so you can design stunning pages quickly with drag and drop instead of code. Jove is also blazing fast, fully customizable via the WordPress UI, fully responsive out of the box, and scores 100% across the board on performance.

My goal with [OllieWP.com](https://www.jove.com) and this theme is to help educate both long-time and new WordPress creators about the many powerful, new features WordPress has to offer. Please feel free to dig through the code and learn a bit more about how to make WordPress block themes. ✌️

## Table of Contents

- [Getting Started with Jove](#getting-started-with-jove)
- [Working with Block Themes](#working-with-block-themes)
  - [Site Editor](#site-editor)
  - [Patterns](#patterns)
  - [Global Styles](#global-styles)
  - [Template Parts](#template-parts)
  - [Export Your Site](#export-your-site)
- [Developer Notes](#developer-notes)
- [License](#license)
- [Beta Feedback](#beta-feedback)
- [About the Creator](#about-the-creator)

## Getting Started with Jove

| Links                                                                                                    | Description                                                           |
| -------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------- |
| [View Jove Demo](https://demo.olliewp.com)                                                               | Check out a full live demo of the Jove theme.                         |
| [Download Jove Theme Zip](https://github.com/OllieWP/jove/releases/latest/download/jove.zip)             | Download the latest Jove theme zip to install on your WordPress site. |
| [Download Jove Child Theme Zip](https://github.com/OllieWP/jove/releases/latest/download/jove-child.zip) | Download the Jove child theme zip for customizations                  |

Jove is built for modern WordPress features and requires WordPress 6.0 or later. To get started, [download the theme](https://github.com/OllieWP/jove/releases/latest/download/jove.zip) and install it into your WordPress website by going to `Appearance → Themes → Add New`.

## Working with Block Themes

Once you activate Jove, it will largely behave like any other traditional WordPress theme. You can create posts and pages just like you always have. However, as a block theme, Jove also supports powerful new features like the site editor, patterns, global styles, and more.

A block theme is a WordPress theme with templates entirely composed of blocks so that in addition to post and page content, the block editor can also be used to edit all areas of the site — headers, footers, templates, and more.

### Site Editor

The WordPress site editor is the new way to build beautiful websites with WordPress. Using blocks, patterns, and a full suite of drag-and-drop design tools, you can build pages right inside WordPress without an extra page builder.

To edit your site via the site editor, go to `Appearance → Editor`. Here, you can create and edit templates, create menus, customize your website styles, color palette, typography, block styles, and much more. This interface is where you'll design and build your site before exporting it later.

https://user-images.githubusercontent.com/1415737/226261553-0bb0a6f9-2c5a-4f84-ac29-9bbce067c98c.mp4

### Patterns

Patterns are pre-designed page elements that can be used to quickly design a page section or a full page layout. Instead of designing a page from scratch, WordPress creators can now lean on patterns to quickly design their full website in the WordPress Site Editor.

You can access Jove's patterns via the block inserter on posts, pages, or in the site editor.

#### Creating page designs with patterns

To create the pages you see on the [Jove theme demo](https://demo.olliewp.com), simply insert Jove's full-page patterns onto any page, and apply the No Page Title template via the editor sidebar. This template removes the default page title, which better accommodates the full-page patterns, so make sure you have an H1 in your design for SEO best practices.

https://user-images.githubusercontent.com/1415737/226257588-c2777dfc-b6af-40fd-b997-70fc78bdd88e.mp4

### Global Styles

Global styles is the user interface in the Site Editor where you can modify all the styles associated with your site. This could be typography, fonts, button colors, link colors, layout defaults, and more.

Global styles is powered by a `theme.json` in the root of the theme folder. This configuration file lets you define site-wide and block-specific styles to be used by the global styles interface.

https://user-images.githubusercontent.com/1415737/226260411-f911f8aa-30ae-48c1-9ea0-0a0512b6dd73.mp4

### Template Parts

A template part is a part of your site that appears across most or all pages. The most common template parts are for the header, footer, and sidebar of a website. Template parts let you easily make global changes to the design or markup of global site elements.

https://github.com/OllieWP/jove/assets/1415737/ccffbd01-0176-4c38-adf3-3ba2d5100a72

### Export Your Site

Once you've finished building and customizing your site with the site editor, you can export a zip to install on another site. While in the site editor, go to the Options menu (upper right hand corner), and select Export under the Tools heading. WordPress will write all of your changes to a theme zip file.

https://user-images.githubusercontent.com/1415737/226259166-d0e3f676-ebe4-4c42-86e0-f9cf175fa0bd.mp4

## Developer Notes

The Jove theme works out of the box, so no build steps are required. However, I have included a Composer file that is used for linting to PHP and WordPress core standards.

- `composer run lint`
- `composer run wpcs:scan`
- `composer run wpcs:fix`

## License

Jove is licensed under the [GPL-3.0 license](https://www.gnu.org/licenses/gpl-3.0.html).

## Beta Feedback

Jove is currently in beta and looking for any and all feedback. Please [open a new issue](https://github.com/OllieWP/jove/issues/new/choose) for bug reports, feature requests, or general feedback.

## About the Creator

Jove was created by [The JoVE Team](https://www.jove.com), a code-slinging, pixel-pushing, team-building, award-winning creator from Planet Earth.

- Check out my [website](https://www.jove.com)
- Find me on [Twitter](https://twitter.com/mikemcalister)
- Read my writings at [Jove](https://www.jove.com) and [Liftoff](https://liftoffcourse.com)
- Watch Jove video tutorials on [YouTube](https://www.youtube.com/@OllieWP)
