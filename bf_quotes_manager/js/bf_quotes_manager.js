jQuery(document).on('ready', function() {
	jQuery('[name=amazon_item_AmazonAsin]').on('blur', function() {
		var data = {
			'action': 'amazon',			
			'id': jQuery(this).val()
			};
		jQuery.post(ajaxurl, data, function(response) {
			var responses = response.split('|');
			/* values */
			jQuery('[name=amazon_item_AmazonTitle]').val(trim(responses[0]));
			jQuery('[name=amazon_item_AmazonDetailPageURL]').val(trim(responses[1]));
			jQuery('[name=amazon_item_AmazonMediumImageURL]').val(trim(responses[2]));
			jQuery('[name=amazon_item_AmazonMediumImageHeight]').val(trim(responses[3]));
			jQuery('[name=amazon_item_AmazonMediumImageWidth]').val(trim(responses[4]));
			jQuery('[name=amazon_item_AmazonAuthor]').val(trim(responses[5]));


			/* new set of values */
			jQuery('[name=amazon_item_AmazonManufacturer]').val(trim(responses[6]));
			jQuery('[name=amazon_item_AmazonStudio]').val(trim(responses[7]));
			
			/* the content */
			jQuery('[name=amazon_item_AmazonSource]').val(trim(responses[8]));
			jQuery('[name=amazon_item_AmazonEditorialReviewContent]').val(trim(responses[9]));
		});
		return false;
	});
});



function trim (str, charlist) {
  // http://kevin.vanzonneveld.net
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: mdsjack (http://www.mdsjack.bo.it)
  // +   improved by: Alexander Ermolaev (http://snippets.dzone.com/user/AlexanderErmolaev)
  // +      input by: Erkekjetter
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      input by: DxGx
  // +   improved by: Steven Levithan (http://blog.stevenlevithan.com)
  // +    tweaked by: Jack
  // +   bugfixed by: Onno Marsman
  // *     example 1: trim('    Kevin van Zonneveld    ');
  // *     returns 1: 'Kevin van Zonneveld'
  // *     example 2: trim('Hello World', 'Hdle');
  // *     returns 2: 'o Wor'
  // *     example 3: trim(16, 1);
  // *     returns 3: 6
  var whitespace, l = 0,
    i = 0;
  str += '';

  if (!charlist) {
    // default list
    whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
  } else {
    // preg_quote custom list
    charlist += '';
    whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
  }

  l = str.length;
  for (i = 0; i < l; i++) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(i);
      break;
    }
  }

  l = str.length;
  for (i = l - 1; i >= 0; i--) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(0, i + 1);
      break;
    }
  }

  return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}