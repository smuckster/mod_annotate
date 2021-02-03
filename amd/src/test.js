import $ from 'jquery';

export const init = () => {
    // Allow highlighted notes to be saved
    let container = document.querySelector('.annotation-container');
    container.addEventListener('mouseup', () => {
        let selection = window.getSelection();
        // Get properties for annotation object to store
        // as long as the selection includes at least
        // one character.
        if(selection.type == 'Range') {
            // If the anchor node of the selection is not
            // an "element" node type (1), work through its
            // parent nodes until the appropriate node type is found.
            let anchor = selection.anchorNode;
            while(anchor.nodeType != 1) {
                anchor = anchor.parentNode;
            }
            // Now that we have the element node, grab its index
            let anchorElementIndex = anchor.getAttribute('id');
            // We also need to store the index of the #text node
            // in the context of the anchor parent node's childNodes array.
            let anchorNodeIndex = Array.prototype.indexOf.call(anchor.childNodes, selection.anchorNode);
            let anchorOffset = selection.anchorOffset;

            // Do the same for the focus node.
            let focus = selection.focusNode;
            while(focus.nodeType != 1) {
                focus = focus.parentNode;
            }
            // Now that we have the element node, grab its index
            let focusElementIndex = focus.getAttribute('id');
            // Again, get the index of the child #text node
            let focusNodeIndex = Array.prototype.indexOf.call(focus.childNodes, selection.focusNode);
            let focusOffset = selection.focusOffset;

            // Assemble a storable annotation object
            let annotation = {
                anchorElementIndex,
                anchorOffset,
                anchorNodeIndex,
                focusElementIndex,
                focusOffset,
                focusNodeIndex
            };

            // If the focus node comes before the anchor node:
            // (Compare the number from the node's id attribute,
            // which begins at the 6th character of the id.)
            if (Number(focusElementIndex.substring(6)) < Number(anchorElementIndex.substring(6))) {
                annotation = swapAnnotationVariables(annotation);
            }
            // If the focus node is the same as the anchor node:
            else if (Number(focusElementIndex.substring(6)) == Number(anchorElementIndex.substring(6))) {
                // If the focus node's offset is smaller than
                // the anchor node's offset:
                if (selection.focusOffset < selection.anchorOffset) {
                    annotation = swapAnnotationVariables(annotation);
                }
            }

            // TODO:
            // Let the user add a note to the selection.
            // When the user clicks the "save" button, save
            // the complete note + annotation in the database.

            window.console.log(annotation);
        }
    });

    // Allow saved notes to be retrieved
    let loadButton = $('.load-button');
    loadButton.on('click', () => {
        // Dummy annotation object for testing
        let annotation = {
            anchorElementIndex: 'index-2',
            anchorOffset: 108,
            anchorNodeIndex: 0,
            focusElementIndex: 'index-2',
            focusOffset: 124,
            focusNodeIndex: 0,
            text: 'im et ante moles'
        };

        let anchorElement = document.querySelector(`#${annotation.anchorElementIndex}`);
        let focusElement = document.querySelector(`#${annotation.focusElementIndex}`);

        let anchorNode = anchorElement.childNodes[annotation.anchorNodeIndex];
        let focusNode = focusElement.childNodes[annotation.focusNodeIndex];

        let selection = window.getSelection();
        // selection.removeAllRanges();
        // selection.addRange(new Range());
        selection.setBaseAndExtent(anchorNode, annotation.anchorOffset, focusNode, annotation.focusOffset);

        // Add an absolutely positioned element above the highlighted text
    });
};

const swapAnnotationVariables = annotation => {
    const tempAnnotation = {...annotation};

    // Swap anchor and focus variables
    annotation.anchorElementIndex = tempAnnotation.focusElementIndex;
    annotation.anchorOffset = tempAnnotation.focusOffset;
    annotation.anchorNodeIndex = tempAnnotation.focusNodeIndex;
    annotation.focusElementIndex = tempAnnotation.anchorElementIndex;
    annotation.focusOffset = tempAnnotation.anchorOffset;
    annotation.focusNodeIndex = tempAnnotation.anchorNodeIndex;

    return annotation;
};