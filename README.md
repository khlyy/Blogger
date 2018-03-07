# Blogger
Simple Blogging system enables authors to publish articles and visitors to read them filter them according to their category using symfony 3.

Description of some routes.
1- "/article/create/{id}"- used to create article where the id is the user's id to check whether he is an author or a visitor.
 author is user with type 1 while visitor is user with type 2. id's is incremental starting from 1.
2- you can filter the articles based on their categories from search bar.
3- you can view the details of specific article by clicking view button.
4- "/seed"- used to seed the data based with some examples. (this should be done using doctrine fixtures but I have problem with composer somehow (did not discover it yet)so I made this route.
