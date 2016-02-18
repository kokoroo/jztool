
<!--
 // 该代码兼容IE/FF
 function insertText (textEl, text)
 {
	/**//*@cc_on
	 @set @ie = true
	 @if (@ie)
	 textEl.focus(); 
	 document.selection.createRange().text = text; 
	 @else @*/
	 if (textEl.selectionStart || textEl.selectionStart == '0') {
		 var startPos = textEl.selectionStart;
		 var endPos = textEl.selectionEnd;
		 textEl.value = textEl.value.substring(0, startPos)
		 + text 
		 + textEl.value.substring(endPos, textEl.value.length);
	 }
	 else {
		 textEl.value += text;
	 }
	/**//*@end @*/
 }
//-->


