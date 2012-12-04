//
//  DataAccess.m
//  MatchTrackerApp
//
//  Created by Jesse on 4/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import "DataAccess.h"
#import <RestKit/RestKit.h>
#import <RestKit/RKJSONParserJSONKit.h>

// Singleton
static DataAccess *sharedDataAccess = nil;

@implementation DataAccess


// Constructor
+ (DataAccess *)sharedDataAccess {
    if(sharedDataAccess == nil){
        sharedDataAccess = [[super allocWithZone:NULL] init];
    }
    return sharedDataAccess;
}

-(void)getData
{
    NSLog(@"get data...");
    [[RKClient sharedClient] get:@"/apitest.php" delegate:self];
}

- (void)request:(RKRequest*)request didLoadResponse:(RKResponse*)response {
    NSLog(@"Loaded payload: %@", [response bodyAsString]);
    RKJSONParserJSONKit* parser = [RKJSONParserJSONKit new];
    NSError *error;
    NSLog(@"%@", [parser objectFromString:[response bodyAsString] error:&error]);
}

@end
