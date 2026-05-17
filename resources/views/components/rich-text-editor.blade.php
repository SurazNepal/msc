<div class="p-5 border border-gray-200 rounded-xl shadow-lg bg-white transition duration-300 ease-in-out">
    {{-- Toolbar --}}
    <div id="editor-toolbar" class="mb-4 flex flex-wrap gap-2 border-b border-gray-100 pb-3">

        {{-- Toolbar Buttons (Note the change from bg-gray-50 to bg-gray-100 for consistent toggling logic) --}}
        <button type="button" data-cmd="bold" title="Bold"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-extrabold transition duration-150">
            B
        </button>

        <button type="button" data-cmd="italic" title="Italic"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 italic transition duration-150">
            I
        </button>

        <button type="button" data-cmd="underline" title="Underline"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 underline transition duration-150">
            U
        </button>

        <button type="button" data-cmd="insertOrderedList" title="Numbered List"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition duration-150">
            <i class="fas fa-list-ol"></i> OL
        </button>

        <button type="button" data-cmd="insertUnorderedList" title="Bulleted List"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition duration-150">
            <i class="fas fa-list-ul"></i> UL
        </button>

        {{-- Heading Buttons: Now use execBlockCommand for block-level changes --}}
        <button type="button" data-tag="H1" onclick="execBlockCommand(this.dataset.tag)" title="Heading 1"
            class="toolbar-btn block-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition duration-150">
            H1
        </button>

        <button type="button" data-tag="H2" onclick="execBlockCommand(this.dataset.tag)" title="Heading 2"
            class="toolbar-btn block-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition duration-150">
            H2
        </button>

        <button type="button" data-tag="H3" onclick="execBlockCommand(this.dataset.tag)" title="Heading 3"
            class="toolbar-btn block-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition duration-150">
            H3
        </button>

        {{-- Link Button --}}
        <button type="button" onclick="execCmd('createLink', prompt('Enter URL:'))" title="Insert Link"
            class="px-4 py-2 text-sm border-2 border-pink-400 rounded-lg bg-pink-50 hover:bg-pink-100 text-pink-600 transition duration-150 font-medium">
            Link
        </button>
    </div>

    {{-- Editable Area --}}
    <div contenteditable="true"
        class="editor w-full min-h-[400px] border border-gray-300 rounded-lg p-4 bg-gray-50 text-gray-800
                prose prose-sm focus:outline-none focus:ring-4 focus:ring-pink-200 focus:border-pink-400 transition duration-150 shadow-inner"
        oninput="this.nextElementSibling.value=this.innerHTML; this.nextElementSibling.dispatchEvent(new Event('input'))">
        {!! $slot !!}
    </div>

    {{-- Hidden input for Livewire binding --}}
    <textarea class="hidden  " {{ $attributes->whereStartsWith('wire:model') }}>
        {!! $slot !!}
    </textarea>
</div>

<script>
    let currentEditor = null;
    let savedSelection = null;
    // Map tag names to their Tailwind classes for consistent styling
    const HEADING_CLASSES = {
        'H1': 'text-4xl font-extrabold mt-8 mb-4',
        'H2': 'text-3xl font-bold mt-6 mb-3',
        'H3': 'text-2xl font-semibold mt-4 mb-2',
        'P': '' // Default paragraph styling (or unset)
    };

    document.addEventListener("DOMContentLoaded", () => {
        const editors = document.querySelectorAll(".editor");
        const toolbar = document.getElementById("editor-toolbar");

        // Bind toolbar buttons
        toolbar.querySelectorAll(".toolbar-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                const cmd = btn.dataset.cmd;
                const val = btn.dataset.val;
                if (cmd) {
                    execCmd(cmd, val);
                } // Block buttons are handled by their onclick
                updateToolbarState();
            });
        });

        editors.forEach(editor => {
            editor.addEventListener("focus", () => {
                currentEditor = editor;
                restoreSelection();
                updateToolbarState();
            });

            editor.addEventListener("keyup", () => {
                saveSelection();
                updateToolbarState();
            });

            editor.addEventListener("mouseup", () => {
                saveSelection();
                updateToolbarState();
            });
        });
    });

    function saveSelection() {
        const sel = window.getSelection();
        if (sel.rangeCount > 0) {
            savedSelection = sel.getRangeAt(0);
        }
    }

    function restoreSelection() {
        const sel = window.getSelection();
        if (savedSelection) {
            sel.removeAllRanges();
            sel.addRange(savedSelection);
        }
    }

    function execCmd(cmd, val = null) {
        if (currentEditor) {
            currentEditor.focus();
            restoreSelection();
            document.execCommand(cmd, false, val);
            saveSelection();
            updateToolbarState();
        }
    }

    /**
     * NEW FUNCTION: Uses document.execCommand('formatBlock') which handles
     * wrapping and unwrapping the current block automatically.
     */
    function execBlockCommand(tag) {
        if (!currentEditor) return;

        currentEditor.focus();
        restoreSelection();

        // 1. Toggles the block tag (e.g., from <p> to <h1>, or from <h1> to <p>)
        document.execCommand('formatBlock', false, tag);

        // 2. The execCommand doesn't apply classes, so we must find the newly formatted
        //    block and apply the Tailwind classes ourselves.
        const selection = window.getSelection();
        let blockNode = selection.anchorNode;
        if (blockNode.nodeType === 3) {
            blockNode = blockNode.parentNode;
        }

        while (blockNode && blockNode !== currentEditor && blockNode.nodeName !== tag) {
            blockNode = blockNode.parentNode;
        }

        if (blockNode && blockNode.nodeName === tag) {
            // Apply desired classes if we converted to a heading
            blockNode.className = HEADING_CLASSES[tag];
        } else if (blockNode && blockNode.nodeName === 'P') {
            // Clear classes if we converted back to a paragraph
            blockNode.className = HEADING_CLASSES['P'];
        }

        saveSelection();
        updateToolbarState();
    }

    /**
     * UPDATED FUNCTION: Corrects B/I/U deactivation logic and adds heading activation logic.
     */
    function updateToolbarState() {
        const toolbar = document.getElementById("editor-toolbar");

        // 1. Check for current block tag (H1, H2, H3, P)
        let activeBlockTag = null;
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            let node = selection.getRangeAt(0).startContainer;
            if (node.nodeType === 3) { // Text node
                node = node.parentNode;
            }
            while (node && node !== currentEditor && !['H1', 'H2', 'H3', 'P'].includes(node.nodeName)) {
                node = node.parentNode;
            }
            if (node && node !== currentEditor) {
                activeBlockTag = node.nodeName;
            }
        }

        // 2. Iterate through all buttons to set active/inactive state
        toolbar.querySelectorAll(".toolbar-btn").forEach(btn => {
            const cmd = btn.dataset.cmd;
            const tag = btn.dataset.tag; // For heading buttons

            let isActive = false;

            // Check formatting commands (B, I, U, Lists)
            if (cmd) {
                // Fix for B, I, U toggle: document.queryCommandState(cmd) returns true if active
                isActive = document.queryCommandState(cmd);
            }
            // Check heading commands (H1, H2, H3)
            else if (tag) {
                // Check if the current block node matches the button's tag
                isActive = (tag === activeBlockTag);
            }

            // Apply/Remove active styles
            if (isActive) {
                btn.classList.add("bg-pink-200", "border-pink-400");
                btn.classList.remove("bg-gray-100", "hover:bg-gray-200");
            } else {
                btn.classList.remove("bg-pink-200", "border-pink-400");
                btn.classList.add("bg-gray-100", "hover:bg-gray-200");
            }
        });
    }
</script>
