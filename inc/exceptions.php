<?php

/**
 * Exception for when wrong data enters out site.
 */
class dataError extends Exception {}

/**
 * Exception for when we dont get data.
 */
class notSent extends Exception {}

/**
 * Exception for when we get an unidentified database error.
 */
class databaseError extends Exception {}

/**
 * Exception for when a users username or password does not match with anything in the database.
 */
class notAuthorized extends Exception {}