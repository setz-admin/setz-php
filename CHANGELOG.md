# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.2.6] - 2026-01-16

### Changes
- cleanup cors namespace


## [0.2.5] - 2026-01-16

### Changes
- fix: add nginx location block for static assets


## [0.2.4] - 2026-01-16

### Changes
- add ai-chat widget


## [0.2.3] - 2026-01-16

### Changes
- add docker-compose.yml as it is needed to setup the sail environmen


## [0.2.2] - 2025-11-27

### Changes
- chore: cleanup
- feat: Docker production setup with smoke tests
- feat: complete chat interface integration and API configuration
- docs: update implementation status with completed chat frontend
- feat: implement RAG chat frontend interface
- feat: add RAG chatbot integration with Python service


## [0.2.1] - 2025-10-06

### Changes
- fix deploy to intranet workflow


## [0.2.0] - 2025-10-06

### Changes
- docs(deploy): add intranet deployment workflow and runner documentation


## [0.1.11] - 2025-10-05

### Changes
- adapt .env.example to usage with sqlite - coder environment


## [0.1.10] - 2025-10-05

### Changes
- add KI to portfolio


## [0.1.9] - 2025-10-05

### Changes
- Add version tag environment variable for Docker images


## [0.1.8] - 2025-10-05

### Changes
- allow version pinning in production


## [0.1.7] - 2025-10-05

### Changes
- Replace named volumes with bind mounts for easier permission management


## [0.1.6] - 2025-10-05

### Changes
- fix: site text


## [0.1.3] - 2025-10-04

### Changes
- fix: Add build dependencies for PHP extensions in production stage


## [0.1.2] - 2025-10-04

### Changes
- fix: Install all npm dependencies for Vite build


## [0.1.1] - 2025-10-04

### Changes
- feat: Add Docker support for containerized deployment
- docs: Umstellung von tar.gz auf Docker Image als Release-Artefakt
- Fix GitHub Actions: Add Node.js setup and Vite build steps
- fix(tests): restore custom Pest expectations lost during Breeze installation
- docs(infra): iteration 3 - Detaillierte Netzwerk-Topologie und Docker-Setup
- docs(infra): iteration 2 - Fritz.box Port-Forwarding & Server-Identifikation
- docs(infra): iteration 1 - Internet-Anbindung
- docs: create DevOpsFlow.md and migrate to main branch


## [0.1.0] - 2025-10-02

### Changes
- feat: rebuild setz.de website in Laravel with modern design
- Add port forwarding documentation for Coder Workspace access
- Update README with Coder Workspace setup and development workflows
- Adapt install.sh for Coder Workspace environment
- Install Laravel Breeze for authentication
- ci the current state
- add and enable dusk on the project
- add test through routing layer: all test pass
- test for db Layer pass; routing layer for appointment passes
- feat: create chirper model
- feat: remove updated_at from user model
- feat: configure pest testing
- add Installation info
- feat: create workflow scripts
- feat: setup Makefile check target
- feat: configure phpinsights
- feat: configure larastan
- feat: configure phpunit watcher
- feat: configure testing with pest
- feat: configure laravel pint
- feat: models are strict, adjust composer dev script
- feat: install dev packages
- feat: create install script
- feat: update environment variables
- feat: dockerize


