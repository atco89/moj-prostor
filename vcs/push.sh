#!/bin/bash

# Script to automate git add, commit, and push with an incremental commit message

# Check if git is installed
if ! command -v git &>/dev/null; then
  printf "Error: git is not installed. Please install git and try again.\n"
  exit 1
fi

# Check if we're inside a git repository
if ! git rev-parse --is-inside-work-tree &>/dev/null; then
  printf "Error: This script needs to be run inside a git repository.\n"
  exit 1
fi

# Get current branch name
current_branch=$(git rev-parse --abbrev-ref HEAD)

# Display current branch name
printf "Current branch: %s\n" "$current_branch"

# Forbid pushing on "main" or "master" branch
#if [[ $current_branch == "main" || $current_branch == "master" ]]; then
#  printf "\e[31mError: Pushing to the %s branch is forbidden.\e[0m\n" "$current_branch"
#  exit 1
#fi

# Prompt for confirmation
read -rp "Are you sure you want to perform the following action (y/n)? " answer

# Check if the user confirms the action
if [[ $answer != "y" && $answer != "Y" ]]; then
  printf "Action cancelled.\n"
  exit 1
fi

# Set the user name and email for the commit
git config user.name "Aleksandar Rakić"
git config user.email "aleksandar.rakic@yahoo.com"

# Get the current commit count for the branch and increment by one for the next commit
commit_number=$(($(git rev-list --count HEAD) + 1))

# Construct the commit message
commit_message="#$commit_number - work in progress."

# Add all changes
git add .

# Commit with the constructed message
git commit -m "$commit_message"

# Push the changes
git push

# Output the commit message for verification
printf "Committed with message: %s\n" "$commit_message"
