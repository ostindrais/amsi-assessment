## Asset Marketing Services, LLC Skills Assessment ##

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

Product Code | Price
--------------------------------------------------
A | $2.00 each or 4 for $7.00
B | $12.00
C | $1.25 or $6 for a six pack
D | $0.15

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
