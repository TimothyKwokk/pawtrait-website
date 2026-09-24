# pawtrait-website
Pawtrait personalised pet clothing and gifts website
# Pawtrait — complete website source

Snapshot: 24 September 2026. Website files are included unchanged.

## Structure

pawtrait/
  README.md
  .openai/hosting.json     Existing Sites deployment configuration
  dist/                   Complete static website / publish this folder
    index.html            Home
    about.html            About and QQ pet-model introduction
    services.html         Services, process and FAQs
    listings.html         Product collection and filters
    contact.html          Contact form and map
    privacy.html          Privacy Policy
    terms.html            Terms of Service
    shipping-returns.html Shipping & Returns
    style.css             Shared styling and responsive layouts
    app.js                Menu, filters, customisation and draft downloads
    images/               QQ photos and product/reference photography

## Open or run

Extract the ZIP. Open dist/index.html in a browser for a basic local view.
For a local web preview, run this from the pawtrait folder if Python 3 is installed:

    python3 -m http.server 8000 --directory dist

Then open http://localhost:8000 . No npm install or build step is needed.
For another static host, publish the contents of dist; the .openai configuration is specific to the existing Sites project.

## Current functionality

Includes navigation, responsive layout, product-category filtering, photo preview,
customisation brief download, and enquiry draft download. Uploaded photos are
previewed locally. Forms do not send messages. There is no checkout, payment
integration, customer database or server-side order processing.

Policy pages describe the preview stage. Company contact details and operational
policies still need completion before commercial launch.

## External resources

Google Fonts, the OpenStreetMap embed and external social-sharing links require
an internet connection. Site images are included locally. This archive includes
the website's authored code and image assets, not the hosting provider's software
or third-party services. No credentials or Git history are included.
