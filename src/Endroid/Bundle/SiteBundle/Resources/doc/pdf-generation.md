# PDF Generation

## General

The generation of PDFs is handled by the KnpSnappyBundle which in turn uses the
[wkhtmltopdf](http://wkhtmltopdf.org/) tool (based on Webkit) to render HTML,
CSS and images to a high quality PDF.

## Features

This bundle provides the following features.

* Cover
* Table of contents
* Introduction
* Example content with sections, subsections, images and tables
* Headers and footers including (sub) section titles and page numbers
* Ability to filter on sections to output only specific items instead of all
* Production: caching of HTML and PDF files and a rebuild action
* Development: regeneration of HTML and PDF files upon each request

## Notes

* The use of external stylesheets poses some problems to the generation
process. For this reason the stylesheets should be embedded within each HTML
file you use.
* Loading HTML via the web server can impose quite a load or even cause the
process to fail. Therefore PDF generation via this bundle is performed in two
steps. First the HTML is generated and stored in the local file system. Then
the generator uses the absolute paths to the resources for building the PDF.
* The cover is attached to the document using [FPDI](http://www.setasign.com/products/fpdi/about/)
to ensure a nice full-page cover. This library does nog require any specific
server configuration.