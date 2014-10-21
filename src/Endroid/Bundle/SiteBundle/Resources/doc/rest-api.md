# REST API

## Generating a client

In order to connect to the REST API you need to create an OAuth client. This
can be achieved by running the following command. After running this command
you are presented the Oauth client ID and secret.

    php app/console endroid:api:client:create --grant-type="client_credentials"

## Authentication

An Oauth client needs to pass a valid access token with each request to the
API. In order to obtain this token the client should request it through the
following URL.

    https://.../oauth/v2/token?client_id=<id>&client_secret=<secret>&grant_type=client_credentials

This call returns a JSON response containing the access token.

## Documentation and testing

The REST API is built on the FOSRestBundle and uses the NelmioApiDocBundle to
generate the API documentation, which also provides a nice sandbox.

    https://.../apidoc/

Fill in the access token in the "api key" field to test your API calls.

## Security

Keep in mind that a secure OAuth implementation requires an SSL connection.
