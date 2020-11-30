# Chat API

[API usage examples](tests/http/chats.http) runnable in IDEA HTTP client

[API controller](api/modules/v1/controllers/ChatController.php)

[Migration](common/migrations/db/m201130_172500_chats.php)

[Authentication and authorization](api/modules/v1/controllers/ChatController.php#L25-36)

- &plus; Soft deletion of chats and messages
- &minus; No swagger API description
- &minus; No search models for resources