OverblogGraphQLBundle - GraphQLConfigurationYamlBundle
======================================================

This bundle handle OverblogGraphQLBundle with Yaml

Default configuration:  
```yaml
overblog_graphql_configuration_yaml:
  mapping:
    auto_discover: 
      bundles:  true
      root_dir: true
    directories:
      - '%kernel.project_dir%/src/Folder'
```

Search for `.yml` or `.yaml` configuration file in the list of directories provided.  
If `mapping.auto_discover.bundles` is enabled (true by default) the parser will look into each bundle `/config/graphql` directory for configuration Yaml files.  
If `mapping.auto_discover.root_dir` is enabled (true by default) the parser will look into the project `/config/graphql` directory for configuration Yaml files.  

