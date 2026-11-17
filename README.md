# PureChatX

A modern, flexible chat formatting and nametag system for **Quark v6** — fully integrated with [PurePermsX](https://github.com/Akari-my/PPX-Quark).

**PureChatX** is another version of the original PureChat, completely rewritten from scratch. It provides customizable chat formats, dynamic nametags, and group-based formatting for Quark servers.

## Features

- Full integration with PurePermsX
- Fully customizable chat format per group
- Nametag formatting with placeholders
- Configurable via `config.yml` & `messages.yml`
- Group-based formatting + linking to permissions/groups
- Supports multiple placeholders (`{name}`, `{prefix}`, `{suffix}`, `{group}`, `{message}`)

## Requirements

- Quark v6 (plugin API `6.0.0`)
- [PurePermsX](https://github.com/Akari-my/PurePermsX) installed and enabled (`depend`)

## Configuration

`config.yml`:
```yaml
default-format: "{prefix}§l{name}§r{suffix} » {message}"
default-nametag: "{prefix}{name}{suffix}"

groups:
  guest:
    prefix: "§7[Guest] "
    suffix: ""
    format: '{prefix}§l{name}§r{suffix} » §7{message}'
    link: "guest"
    nametag: "§7{name}"
```

`messages.yml` (excerpt):
```yaml
prefix: "§7[§6PCX§7] "

reload:
  success: "Configuration reloaded successfully."

tag:
  success:
    create: "§7Tag §6{name}§7 created."
    delete: "§7Tag §6{name}§a successfully deleted."
    link: "§7Tag §6{tag}§a linked to group §6{group}§7."
    set: "§7Player §6{player}§a has been assigned to tag §6{tag}."
```

## Commands

| Command | Description |
|--------|-------------|
| `/pcx reload` | Reload plugin configuration |
| `/pcx create <tag>` | Create a tag |
| `/pcx delete <tag>` | Delete a tag |
| `/pcx set <player> <tag>` | Assign a tag (and group) to a player |
| `/pcx setprefix <tag> <prefix>` | Set prefix for a tag |
| `/pcx setsuffix <tag> <suffix>` | Set suffix for a tag |
| `/pcx setformat <tag> <format>` | Set chat format |
| `/pcx link <tag> <group>` | Link tag to a PurePermsX group |
| `/pcx list` | List all registered tags |

## Placeholders

Use these in formats & nametags:

- `{prefix}` — tag/group prefix
- `{suffix}` — tag/group suffix
- `{name}` — player display name
- `{group}` — player group
- `{message}` — chat message

## Plugin Structure

```
src/
└── Mellooh/
    └── PureChatX/
        ├── commands/
        │   └── args/             # Subcommand handlers
        ├── listener/             # Chat/nametag event handling
        ├── manager/              # Format & config handling
        ├── utils/                # Message utilities
        └── PCX.php               # Main plugin class
```

Manifest: `plugin.toml` (Quark v6).

## Developer

- Plugin by [**Mellooh**](https://github.com/Akari-my)

## License

This project is open-source and licensed under the [MIT License](./LICENSE).

## Related

- [PurePermsX](https://github.com/Akari-my/PurePermsX) — Group/permission manager