# IMu api

This application serves as a layer above the IMu API outlines [here](https://emu.kesoftware.com/support/downloads/imu) (Note: login required).  It's purpose is to make the IMu API easier to use and also open it in a REST style API that can be used by other webservers.

# Endpoints

## Images

url: http://*imu server*/api/images?irn=*irn*

**Variables**

* irn: The irn of the catalog object you are looking for

**Response**

This function responds with an image file if it succeeds or an HTTP ERROR if it fails

**Errors**

* HTTP 503 - Can't connect to IMu server (may be down or configured incorrectly)
* HTTP 400 - Malformed request (Did you set the IRN?)
* HTTP 406 - Something happened when trying to find the item
* HTTP 404 - An object with that IRN could not be found.

## Multimedia

url: http://*imu server*/api/multimedia?irn=*irn*

**Variables**

* irn: The irn of the multimedia object you are looking for

**Response**

This function responds with a file if it succeeds or an HTTP ERROR if it fails

**Errors**

* HTTP 503 - Can't connect to IMu server (may be down or configured incorrectly)
* HTTP 400 - Malformed request (Did you set the IRN?)
* HTTP 406 - Something happened when trying to find the item
* HTTP 404 - An object with that IRN could not be found.
