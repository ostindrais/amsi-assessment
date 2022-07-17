### Asset Marketing Services, LLC Skills Assessment ###

(All code is in the `amsi-assessment` branch)

Part 1:
<pre>
What is the output of the following PHP code and explain why:
$a = '1';
$b = &$a;
$b = "2$b";
echo $a.", ".$b;
</pre>

The output will be:
`1, 21`

1. The variable `$a` is first set to the string value `1`.
2. The variable `$b` is then set as a reference to the variable `$a`.
3. Then variable `$b` is reassigned as the string `2` plus variable `$b`. But because the strings are in double-quotes, the value of `$b` (`1`) is used. If `$b` wasn't `2` but was instead `legit2quit`, then at the end of this step `$b` would equal `2legit2quit`.
4. Finally, the value of `$a` is printed, followed by a comma, a space and the value of `$b` using the string concatenation operator.

<hr />
Part 2:
<pre>
Write the following feature in PHP OOP approach:

Consider a store where items have prices per unit but also volume prices. For example, apples
may be $1.00 each or 4 for $3.00.

Implement a point-of-sale scanning API that accepts an arbitrary ordering of products (similar to
what would happen at a checkout line) and then returns the correct total price for an entire
shopping cart based on the per unit prices or the volume prices as applicable.

Here are the products listed by code and the prices to use (there is no sales tax):

<pre>
Product Code | Price
A            | $2.00 each or 4 for $7.00
B            | $12.00
C            | $1.25 or $6 for a six pack
D            | $0.15
</pre>
There should be a top level point of sale terminal Service Object that looks something like the
pseudo-code below:

terminal->setPricing(...)
terminal->scan("A")
terminal->scan("C")
result = terminal->total

You are free to design and implement the rest of the code however you wish, including how you
specify the prices in the system.

Here are the minimal inputs you should use for your test cases. These test cases must be
shown to work in your program:

1. Scan these items in this order: ABCDABAA; Verify the total price is $32.40.
2. Scan these items in this order: CCCCCCC; Verify the total price is $7.25.
3. Scan these items in this order: ABCD; Verify the total price is $15.40.
</pre>

Feature is in module AmsAssesment\POSScanner, found in `app/code/AmsAssessment/POSScanner`.

<hr />
Part 3:
<pre>
Please review the following story and provide easy-to-understand steps on the best
way to build this feature:

“As an Admin - I want to the ability for a customer to download a CSV file of all the items
that are currently in their cart and this feature can be enabled or disabled as needed by
the Admin.”
</pre>

I would want to know some additional information:
1. Where will this download feature be accessed?
2. Is the UI for it to be consistent, i.e. should it be setup as a Block?
3. What should happen if there are no items in the cart?
4. What data will be included in the CSV?
5. Will the file download be attached to another action?

This is rather incomplete. But I would do something like:
1. Create a new Magento 2 module.
2. Create CSV download of current cart items in new module.
4. Create Admin panel to enable/disable CSV download.
<hr />
Part 4:

<pre>
Based on the story above - please code the feature needed in a Magento 2 module
with 50% unit test coverage by leveraging the CORE Magento 2 codebase.
</pre>
Feature is in module AmsAssessment\CartCSVDownload, found in `app/code/AmsAssessment/CartCSVDownload`.

Admittedly I'm at a bit of a loss. My memory of how to setup unit tests "properly" in Magento is hazy, so I've left that up for discussion during the technical interview.
I am confident that what I've coded will "work", it just needs some guided work to fit the Magento ecosystem better.
<hr />

### Comments ###

Part 1 was a good exercise showing basic PHP knowledge.
Part 2 is where I believe I did my best. OOP is second-nature to me. TDD is something that I've recently latched onto--and by recently I mean within the last decade. 
It's fundamentally changed the way I code and my code's quality when I use it is much, much improved.
Part 3 & 4 are intimately tied together in my mind. Magento 2's methodologies would completely inform how I would architect the feature. My lack of intimate knowledge of M2 affected the end result.
As I say above, with a bit of guidance I'm sure I'd create something modular that could be reused again & again.

Thank you for the fantastic opportunity.
I look forward to the technical interview.

Ostin Drais
ostin@ostindrais.com
