#
# This is an example VCL file for Varnish.
#
# It does not do anything by default, delegating control to the
# builtin VCL. The builtin VCL is called when there is no explicit
# return statement.
#
# See the VCL chapters in the Users Guide for a comprehensive documentation
# at https://www.varnish-cache.org/docs/.

# Marker to tell the VCL compiler that this VCL has been written with the
# 4.0 or 4.1 syntax.
vcl 4.1;

# Default backend definition. Set this to point to your content server.
backend default {
    .host = "127.0.0.1";
    .port = "9000";
}

sub vcl_recv {
    if (req.url ~ "MySQL_tiles\.php" || req.url ~ "MySQL_update\.php" || req.url ~ "\.(png|gif|jpg)$") {
        unset req.http.cookie;
    }
}

sub vcl_backend_response {
    if (bereq.url ~ "MySQL_tiles\.php") {
        unset beresp.http.set-cookie;
        unset beresp.http.cache-control;
        unset beresp.http.pragma;
        unset beresp.http.expires;
        set beresp.ttl = 10m;
        set beresp.uncacheable = false;
    } elseif (bereq.url ~ "MySQL_update\.php") {
        unset beresp.http.set-cookie;
        unset beresp.http.cache-control;
        unset beresp.http.pragma;
        set beresp.ttl = 5s;
        set beresp.uncacheable = false;
    } elseif (bereq.url ~ "\.(png|gif|jpg)$") {
        unset beresp.http.set-cookie;
        set beresp.ttl = 8h;
    } else {
        set beresp.ttl = 0s;
    }
}

sub vcl_deliver {
    # Happens when we have all the pieces we need, and are about to send the
    # response to the client.
    #
    # You can do accounting or modifying the final object here.
}
