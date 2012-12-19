//
//  FirstViewController.m
//  MatchTrackerApp
//
//  Created by Jesse on 4/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import "FirstViewController.h"
#import <RestKit/RestKit.h>
#import "DataAccess.h"
#import "Sport.h"

@interface FirstViewController ()
@end

@implementation FirstViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    // Create RestKit data acccess singleton object
    //DataAccess *sharedDataAccess = [DataAccess sharedDataAccess];
    //[sharedDataAccess getData];
    
    // Configure RestKit API Mapping    
    RKObjectMapping *sportsMapping = [RKObjectMapping mappingForClass:[Sport class]];
    [sportsMapping mapKeyPath:@"id" toAttribute:@"identifier"];
    [sportsMapping mapKeyPath:@"name" toAttribute:@"name"];
    

    // Load objects
    sportsMapping.rootKeyPath = @"sports";
    [[RKObjectManager sharedManager] loadObjectsAtResourcePath:@"/sports" usingBlock:^(RKObjectLoader *loader) {
        loader.objectMapping = sportsMapping;
        loader.onDidLoadObjects = ^(NSArray* objects) {
            //RKLogInfo(@"Load collection of Sports: %@", objects);
            
            //NSMutableArray *sports = [[NSMutableArray alloc] init];
            for(Sport *newSport in objects) {
                NSLog(@"Sport met id=%@ en naam=%@", [newSport identifier], [newSport name]);
            }
        };
        loader.onDidFailWithError = ^(NSError* error) {
            NSLog(@"Error: %@", error.localizedDescription);
        };
    }];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
