                    const option = document.createElement('option');
                    option.value = branch.id;
                    option.textContent = branch.name;
                    if (branch.id === '{{ old('branch_id', $post->branch_id ?? '') }}') {
                        option.selected = true;
                    }
                    branchDropdown.appendChild(option); 