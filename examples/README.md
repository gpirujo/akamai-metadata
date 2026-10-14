# Examples

Sample property configuration files showing how `akamai-metadata` is used in practice, adapted from a real-world setup (anonymized).

- `common.php` — shared helper functions reused across property configs (managed origin, standard caching/compression rules).
- `www.oldgroup.com.php` — a full property configuration with its behaviors defined inline.
- `api.crashmycar.in.php` — a property configuration that uses the `common.php` helpers instead, including a per-hostname override rule ("Staging").

`managed-cdn.pem` is included only to show the shape of a `customCA()` reference — it is **not** a usable certificate.
