<?php 

function ReturnEmailHTML($Data) {

	return

		"<UL>" .

		"<P>" .
		"<B>February 25<SUP>th</SUP> is rapidly approaching.</B>" .
		"</P>" .

		"<P>" .
		"I have included the walk sheet and a sample petition so you " . 
		"can familiarize yourself with the material." .
		"</P>" .

		"<P>" .
		"All you need to do is get <B>" . $Data["TotalSignatures"] . " signatures</B> from voters " . 
		"on the walk sheet onto the petition. <B>That's it!</B>" .
		"</P>" .

		"<P>" .
		"According to the voter file, you live at:" .
		"<UL>" .
		"<I>" . $Data["FullAddress"] . "<BR>" .
		$Data["FullAddressLine2"] . "<BR></I>" .
		"</UL>" .
		"</P>" .

		"<P>" .
		"That address is located in the <B>assembly " . 
		"district " . $Data["ASSEMDISTR"] . "</B> in the " .
		"<B>electoral district " . $Data["ELECTDISTR"]  . "</B>. " .
		"If that is incorrect," .
		"feel free to contact email me so we can fix it." .
		"</P>" .

		"<P>" .
		"<B>There are " . $Data["NumberVoters"] . " " . $Data["PartyName"] .
		" voters</B> which means you need to collect " .
		"<B>" .  $Data["TotalSignatures"] . " signatures</B> " .
		"from " .  $Data["PartyNamePlural"] . " in your area." .
		"</P>" .

		"<P>" .
		"The County Committee petitioning window will start on " .
		"February 25th, 2019. " .
		"<U><B>You cannot begin collecting signatures before that date.</B></U>" .
		"</P>" .

		"<P>" .
		"If you have any questions, feel free to reply to this message." .
		"</P>" .

		"<P>" .
		"<B>" .
		"Don't run for County Committee alone; get a few friends from other " .
		"parts of $FixedCounty county to run with you. " .
		"</B>" .
		"</P>" .

		"<P>" .
		"<B>" .
		"<FONT COLOR=\"BROWN\">Please share this email with anyone you know " .
		"that could be interested in running and having them visit " .
		"<A HREF=\"https://RepMyBlock.NYC\">https://RepMyBlock.NYC</A>.</FONT>" .
		"</B>" .
		"</P>" .

		"<P>" .
		"We need " .  $Data["PartyNamePlural"]  . " from every part of the Bronx, Brooklyn, and Queens, " . 
		"so feel free to get them to do it as well." .
		"</P>" .

		"</UL>" .

		"<P>" .
		"Regards,<BR>" .
		"Theo Chino<BR>" .
		"<I>(718) 701.0140</I>" .
		"</P>";

}
?>

