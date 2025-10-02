#!/bin/bash

# make_release.sh - Semantic Versioning Release Script
# Usage: ./make_release.sh [major|minor|patch]

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if parameter is provided
if [ $# -ne 1 ]; then
    echo -e "${RED}Error: Missing parameter${NC}"
    echo "Usage: $0 [major|minor|patch]"
    exit 1
fi

BUMP_TYPE=$1

# Validate parameter
if [[ ! "$BUMP_TYPE" =~ ^(major|minor|patch)$ ]]; then
    echo -e "${RED}Error: Invalid parameter '$BUMP_TYPE'${NC}"
    echo "Usage: $0 [major|minor|patch]"
    exit 1
fi

# Paths
VERSION_FILE="VERSION.txt"
CHANGELOG_FILE="CHANGELOG.md"

# Check if VERSION.txt exists, if not create it with 0.0.0
if [ ! -f "$VERSION_FILE" ]; then
    echo "0.0.0" > "$VERSION_FILE"
    echo -e "${YELLOW}Created $VERSION_FILE with initial version 0.0.0${NC}"
fi

# Read current version
CURRENT_VERSION=$(cat "$VERSION_FILE")
echo -e "${GREEN}Current version: $CURRENT_VERSION${NC}"

# Parse version (a.b.c)
IFS='.' read -r -a VERSION_PARTS <<< "$CURRENT_VERSION"
MAJOR="${VERSION_PARTS[0]}"
MINOR="${VERSION_PARTS[1]}"
PATCH="${VERSION_PARTS[2]}"

# Bump version according to semantic versioning
case "$BUMP_TYPE" in
    major)
        MAJOR=$((MAJOR + 1))
        MINOR=0
        PATCH=0
        ;;
    minor)
        MINOR=$((MINOR + 1))
        PATCH=0
        ;;
    patch)
        PATCH=$((PATCH + 1))
        ;;
esac

NEW_VERSION="$MAJOR.$MINOR.$PATCH"
echo -e "${GREEN}New version: $NEW_VERSION${NC}"

# Get the last release tag or first commit
LAST_TAG=$(git describe --tags --abbrev=0 2>/dev/null || git rev-list --max-parents=0 HEAD)

# Generate changelog entry
echo -e "${YELLOW}Generating changelog...${NC}"
CHANGELOG_ENTRY="## [$NEW_VERSION] - $(date +%Y-%m-%d)

### Changes
$(git log "$LAST_TAG"..HEAD --pretty=format:"- %s" --no-merges)

"

# Create or update CHANGELOG.md
if [ ! -f "$CHANGELOG_FILE" ]; then
    echo "# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

$CHANGELOG_ENTRY" > "$CHANGELOG_FILE"
    echo -e "${GREEN}Created $CHANGELOG_FILE${NC}"
else
    # Insert new entry after the header
    TEMP_FILE=$(mktemp)
    HEAD_LINES=$(grep -n "^## \[" "$CHANGELOG_FILE" | head -1 | cut -d: -f1)

    if [ -z "$HEAD_LINES" ]; then
        # No previous releases, append to end
        echo "$CHANGELOG_ENTRY" >> "$CHANGELOG_FILE"
    else
        # Insert before first release entry
        head -n $((HEAD_LINES - 1)) "$CHANGELOG_FILE" > "$TEMP_FILE"
        echo "$CHANGELOG_ENTRY" >> "$TEMP_FILE"
        tail -n +$HEAD_LINES "$CHANGELOG_FILE" >> "$TEMP_FILE"
        mv "$TEMP_FILE" "$CHANGELOG_FILE"
    fi
    echo -e "${GREEN}Updated $CHANGELOG_FILE${NC}"
fi

# Update VERSION.txt
echo "$NEW_VERSION" > "$VERSION_FILE"
echo -e "${GREEN}Updated $VERSION_FILE${NC}"

# Git operations
echo -e "${YELLOW}Committing changes...${NC}"
git add "$VERSION_FILE" "$CHANGELOG_FILE"
git commit -m "chore: release version $NEW_VERSION

- Bumped version from $CURRENT_VERSION to $NEW_VERSION
- Updated CHANGELOG.md

🤖 Generated with [Claude Code](https://claude.com/claude-code)

Co-Authored-By: Claude <noreply@anthropic.com>"

# Create git tag
echo -e "${YELLOW}Creating git tag v$NEW_VERSION...${NC}"
git tag -a "v$NEW_VERSION" -m "Release version $NEW_VERSION"

# Push changes and tags
echo -e "${YELLOW}Pushing to remote...${NC}"
git push origin HEAD
git push origin "v$NEW_VERSION"

echo -e "${GREEN}✅ Release $NEW_VERSION completed successfully!${NC}"
echo -e "${GREEN}Tag: v$NEW_VERSION${NC}"
echo ""
echo -e "${YELLOW}Summary:${NC}"
echo "  • Version: $CURRENT_VERSION → $NEW_VERSION"
echo "  • Changelog: Updated"
echo "  • Git tag: v$NEW_VERSION created and pushed"
